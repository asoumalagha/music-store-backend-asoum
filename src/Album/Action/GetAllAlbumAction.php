<?php

declare(strict_types=1);

namespace Asoum\Album\Action;

use Asoum\Album\Model\AlbumModel;
use Slim\Http\Request;
use Slim\Http\Response;

class GetAllAlbumAction
{
    private $albumModel;

    public function __construct(AlbumModel $albumModel)
    {
        $this->albumModel = $albumModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = $this->albumModel->getAllAlbum();
        return $response->withJson($result);
    }
}