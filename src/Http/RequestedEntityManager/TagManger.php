<?php
declare(strict_types = 1);

namespace App\Http\RequestedEntityManager;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagManger
 *
 * @package App\Http\RequestedEntityManager
 */
class TagManger
{
    private const REQUESTED_ENTITY_ID_NAME = 'tagId';
    
    /**
     * @var TagRepository
     */
    private $tagRepository;
    
    /**
     * TagManger constructor.
     *
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
    
    /**
     * @param Request $request
     *
     * @return Tag
     */
    public function getRequestedEntity(Request $request): Tag
    {
        $tagId = $request->get(self::REQUESTED_ENTITY_ID_NAME);
        
        $tag = $this->tagRepository->find($tagId);
        if (null === $tag) {
            throw new NotFoundHttpException(sprintf('Tag with id `%s` not found', $tagId));
        }
        
        return $tag;
    }
}
