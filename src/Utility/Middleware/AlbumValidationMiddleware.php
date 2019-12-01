<?php


namespace Asoum\Utility\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AlbumValidationMiddleware extends ValidationMiddleware
{
    public function __invoke(Request $request, Response $response, Callable $next): Response
    {
        $this->setParameters('albumId', 'is_int');
        return parent::handleMiddleware($request, $response, $next);
    }
}