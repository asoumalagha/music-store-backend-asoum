<?php

declare(strict_types=1);

namespace Asoum\Utility\Middleware;



use Slim\Http\Request;
use Slim\Http\Response;

class NameValidationMiddleware extends ValidationMiddleware
{
    public function __invoke(Request $request, Response $response, Callable $next): Response
    {
        $this->setParameters('name','is_string');
        return parent::handleMiddleware($request, $response, $next);
    }
}