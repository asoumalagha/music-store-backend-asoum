<?php

declare(strict_types=1);

namespace Asoum\Utility\Action;


use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class NotAllowedErrorHandlerAction
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, array $methods)
    {
        $this->logger->error('405 method not allowed',
            [
                'SERVER' => $_SERVER,
                'GET' => $_GET,
                'POST' => $_POST
            ]);
        return $response
            ->withJson([
                'success' => false,
                'status' => 405
            ])
            ->withStatus(405);
    }
}