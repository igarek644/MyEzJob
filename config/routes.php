<?php
declare(strict_types = 1);

use App\Controller\ArticleController;
use App\Controller\ArticleTagController;
use App\Controller\TagController;
use App\Controller\Web\SearchController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('article_create', '/api/v1/articles')
        ->controller([ArticleController::class, 'createArticle'])
        ->methods(['POST']);
    
    $routes->add('article_get_collection', '/api/v1/articles')
        ->controller([ArticleController::class, 'getCollection'])
        ->methods(['GET']);
    
    $routes->add('article_edit', '/api/v1/articles/{articleId}')
        ->controller([ArticleController::class, 'editArticle'])
        ->methods(['PUT']);
    
    $routes->add('tag_create', '/api/v1/tags')
        ->controller([TagController::class, 'create'])
        ->methods(['POST']);
    
    $routes->add('tag_get_by_name', '/api/v1/tags/{name}')
        ->controller([TagController::class, 'getItemByName'])
        ->methods(['GET'])
        ->requirements(['name' => '^[A-Za-z]+$']);
    
    $routes->add('article_tag_add', '/api/v1/articles/{articleId}/tags')
        ->controller([ArticleTagController::class, 'addTag'])
        ->methods(['POST'])
        ->requirements(['articleId' => '\d+']);
    
    $routes->add('article_tag_delete', '/api/v1/articles/{articleId}/tags')
        ->controller([ArticleTagController::class, 'removeTag'])
        ->methods(['DELETE'])
        ->requirements(['articleId' => '\d+']);
    
    $routes->add('search_page', '/search')
        ->controller([SearchController::class, 'indexAction']);
};
