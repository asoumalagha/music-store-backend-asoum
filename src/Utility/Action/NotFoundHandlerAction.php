<?php

declare(strict_types=1);

namespace Asoum\Utility\Action;


use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundHandlerAction
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->logger->error('404 error on request ',
            [
                'SERVER' => $_SERVER,
                'GET' => $_GET,
                'POST' => $_POST
            ]);
        return $response
            ->withJson([
                'success' => false,
                'status code' => 404
            ])
            ->withStatus(404);
    }
}