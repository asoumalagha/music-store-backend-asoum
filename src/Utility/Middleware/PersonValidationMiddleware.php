<?php


namespace Asoum\Utility\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class PersonValidationMiddleware extends ValidationMiddleware
{
    public function __invoke(Request $request, Response $response, Callable $next): Response
    {
        $this->setParameters('personId', 'is_int');
        return parent::handleMiddleware($request, $response, $next);
    }
}