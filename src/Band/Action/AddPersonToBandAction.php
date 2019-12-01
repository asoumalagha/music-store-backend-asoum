<?php

declare(strict_types=1);

namespace Asoum\Band\Action;


use Asoum\Band\Model\BandModel;
use Slim\Http\Request;
use Slim\Http\Response;

class AddPersonToBandAction
{
    private $bandModel;

    public function __construct(BandModel $bandModel)
    {
        $this->bandModel = $bandModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->bandModel->addPersonToBand(
            (int)$args['id'],
            (int)$jsonData['person']
        );
        return $response->withJson(['success' => $result]);
    }
}