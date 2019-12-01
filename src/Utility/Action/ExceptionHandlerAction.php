<?php

declare(strict_types=1);

namespace Asoum\Utility\Action;


use Exception;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class ExceptionHandlerAction
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, Exception $exception)
    {
        $this->logger->error($exception->getMessage(),
            [
                'exception' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'trace' => $exception->getTrace()
                ],
                'SERVER' => $_SERVER,
                'GET' => $_GET,
                'POST' => $_POST
            ]);
        return $response
            ->withJson(['Error message' => $exception->getMessage()])
            ->withStatus(400);
    }
}