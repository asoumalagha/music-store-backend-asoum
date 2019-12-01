<?php

declare(strict_types=1);

namespace Asoum\Person\Action;


use Asoum\Person\Model\PersonModel;
use Slim\Http\Request;
use Slim\Http\Response;

class AddNewPersonAction
{
    private $personModel;

    public function __construct(PersonModel $personModel)
    {
        $this->personModel = $personModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->personModel->addNewPerson($jsonData['name']);
        return $response->withJson(['success'=>$result]);
    }
}

