<?php

declare(strict_types=1);

namespace Asoum\User\Action;


use Asoum\Song\Model\SongModel;
use Asoum\User\Model\UserModel;
use Slim\Http\Request;
use Slim\Http\Response;

class AddNewUserAction
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->userModel->addNewUser(
            $jsonData['name'],
            $jsonData['email'],
            $jsonData['password']
            );
        return $response->withJson(['success'=>$result]);
    }
}