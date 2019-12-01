<?php

declare(strict_types=1);

namespace Asoum\Band\Action;


use Asoum\Band\Model\BandModel;
use Slim\Http\Request;
use Slim\Http\Response;

class GetAllBandAction
{
    private $bandModel;

    public function __construct(BandModel $bandModel)
    {
        $this->bandModel = $bandModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = $this->bandModel->getAllBand();
        return $response->withJson($result);
    }
}