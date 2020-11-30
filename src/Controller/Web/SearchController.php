<?php
declare(strict_types = 1);

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchController
 *
 * @package App\Controller\Web
 */
class SearchController extends AbstractController
{
    /**
     * @return Response|null
     */
    public function indexAction(): Response
    {
        return $this->render('template.html.twig');
    }
}
