<?php
declare(strict_types = 1);

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 *
 * @package App\EventListener
 */
class ExceptionListener
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = $this->createApiResponse($exception);
        $event->setResponse($response);
    }
    
    /**
     * Creates the ApiResponse from any Exception
     *
     * @param \Exception $exception
     *
     * @return Response
     */
    private function createApiResponse(\Exception $exception)
    {
        return new JsonResponse(
            [
                'errors' => [
                    'message' => $exception->getMessage(),
                ]
            ]
        );
    }
}