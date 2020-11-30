<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagController
 *
 * @package App\Controller
 */
class TagController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @var TagRepository
     */
    private $tagRepository;
    
    /**
     * TagController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param TagRepository          $tagRepository
     */
    public function __construct(EntityManagerInterface $entityManager, TagRepository $tagRepository)
    {
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
    }
    
    /**
     * @param string $name
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function getItemByName(string $name)
    {
        $tag = $this->tagRepository->findOneBy(['name' => $name]);
    
        if (null === $tag) {
            throw new NotFoundHttpException(sprintf('Tag with name `%s` not found', $name));
        }
    
        return new JsonResponse(['data' => ['id' => $tag->getId(), 'name' => $tag->getName()]]);
    }
    
    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Request $request)
    {
        $tag = new Tag();
        $tagForm = $this->createForm(TagType::class, $tag);
        $tagForm->submit($request->request->all());
    
        $errors = $tagForm->getErrors(true);
        if (count($errors) > 0) {
            throw new BadRequestHttpException($errors->current()->getMessage());
        }

        $this->entityManager->persist($tag);
        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new BadRequestHttpException(sprintf('Tag `%s` already exists', $tag->getName()));
        }
        
        return new JsonResponse(['data' => ['id' => $tag->getId()]], Response::HTTP_CREATED);
    }
}
