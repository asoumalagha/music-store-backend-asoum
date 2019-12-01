<?php

declare(strict_types=1);

namespace Asoum\Utility\Action;


use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PHPErrorHandlerAction
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Error $error)
    {
        $this->logger->error($error->getMessage(),
            [
                'error' => [
                    'message' => $error->getMessage(),
                    'code' => $error->getCode(),
                    'file' => $error->getFile(),
                    'trace' => $error->getTrace()
                ],
                'SERVER' => $_SERVER,
                'GET' => $_GET,
                'POST' => $_POST
            ]);
        return $response
            ->withJson(['Error message' => $error->getMessage()])
            ->withStatus(500);
    }
}