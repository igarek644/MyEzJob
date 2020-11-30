<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Form\TagIdType;
use App\Http\RequestedEntityManager\ArticleManager;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleTagController
 *
 * @package App\Controller
 */
class ArticleTagController extends AbstractController
{
    /**
     * @var ArticleManager
     */
    private $articleRequestedEntityManager;
    
    /**
     * @var TagRepository
     */
    private $tagRepository;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * ArticleTagController constructor.
     *
     * @param ArticleManager         $articleManager
     * @param TagRepository          $tagRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ArticleManager $articleManager,
        TagRepository $tagRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->articleRequestedEntityManager = $articleManager;
        $this->tagRepository = $tagRepository;
        $this->entityManager = $entityManager;
    }
    
    /**
     * @param Request $request
     * @param int     $articleId
     *
     * @return JsonResponse
     */
    public function addTag(Request $request, int $articleId)
    {
        $article = $this->articleRequestedEntityManager->getRequestedEntity($request);
        
        $form = $this->createForm(TagIdType::class);
        $form->submit($request->request->all());
        
        $errors = $form->getErrors(true);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->current()->getMessage());
        }
        
        $tag = $this->tagRepository->find($form->getData()['tag_id']);
        if (null === $tag) {
            throw new NotFoundHttpException('Tag not found');
        }
        
        $article->addTag($tag->getName());
        $this->entityManager->flush();
        
        return new JsonResponse(['data' => ['id' => $article->getId()]]);
    }
    
    /**
     * @param Request $request
     * @param int     $articleId
     *
     * @return JsonResponse
     */
    public function removeTag(Request $request, int $articleId)
    {
        $article = $this->articleRequestedEntityManager->getRequestedEntity($request);

        $form = $this->createForm(TagIdType::class);
        $form->submit($request->request->all());
    
        $errors = $form->getErrors(true);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->current()->getMessage());
        }
    
        $tag = $this->tagRepository->find($form->getData()['tag_id']);
        if (null === $tag) {
            throw new NotFoundHttpException('Tag not found');
        }
    
        $article->removeTag($tag->getName());
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    
        return new JsonResponse(['data' => ['id' => $article->getId()]]);
    }
}
