<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Http\RequestedEntityManager\ArticleManager;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use FOS\ElasticaBundle\HybridResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleController
 *
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @var TransformedFinder
     */
    private $elasticFinder;
    
    /**
     * @var ArticleManager
     */
    private $articleRequestedEntityManager;
    
    /**
     * ArticleController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param TransformedFinder      $elasticFinder
     * @param ArticleManager         $articleManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TransformedFinder $elasticFinder,
        ArticleManager $articleManager
    ) {
        $this->entityManager = $entityManager;
        $this->elasticFinder = $elasticFinder;
        $this->articleRequestedEntityManager = $articleManager;
    }
    
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function createArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        $errors = $form->getErrors(true);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->current()->getMessage());
        }
        
        $this->entityManager->persist($article);
        $this->entityManager->flush();
        
        return new JsonResponse(['data' => ['id' => $article->getId(),],], Response::HTTP_CREATED);
    }
    
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function editArticle(Request $request)
    {
        $article = $this->articleRequestedEntityManager->getRequestedEntity($request);
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());
        
        $errors = $form->getErrors(true);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->current()->getMessage());
        }
        
        $this->entityManager->flush();
        
        return new JsonResponse(['data' => ['id' => $article->getId(),],], Response::HTTP_NO_CONTENT);
    }
    
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCollection(Request $request): JsonResponse
    {
        $query = (string)$request->query->get('q', '');
        $result = $this->elasticFinder->findHybrid($query, 15);
        
        $response = [];
        /** @var HybridResult $item */
        foreach ($result as $item) {
            $response[] = [
                'id' => $item->getTransformed()->getId(),
                'title' => $item->getTransformed()->getTitle(),
                'description' => $item->getTransformed()->getDescription(),
                'tags' => $item->getTransformed()->getTags(),
            ];
        }
        
        return new JsonResponse(['data' => $response]);
    }
}
