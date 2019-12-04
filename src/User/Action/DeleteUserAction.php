<?php

declare(strict_types=1);

namespace Asoum\Song\Action;


use Asoum\Song\Model\SongModel;
use Asoum\User\Model\UserModel;
use Slim\Http\Request;
use Slim\Http\Response;

class DeleteUserAction
{
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = $this->userModel->deleteUser((int)$args['id']);
        return $response->withJson(['success'=>$result]);
    }

}