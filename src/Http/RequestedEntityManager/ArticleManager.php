<?php
declare(strict_types = 1);

namespace App\Http\RequestedEntityManager;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleManager
 *
 * @package App\Http\RequestedEntityManager
 */
class ArticleManager
{
    private const REQUESTED_ENTITY_ID_NAME = 'articleId';
    
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    
    /**
     * ArticleManager constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    
    /**
     * @param Request $request
     *
     * @return Article
     */
    public function getRequestedEntity(Request $request): Article
    {
        $articleId = $request->get(self::REQUESTED_ENTITY_ID_NAME);
    
        $article = $this->articleRepository->find($articleId);
        if (null === $article) {
            throw new NotFoundHttpException(sprintf('Article with id `%s` not found', $articleId));
        }
    
        return $article;
    }
}
