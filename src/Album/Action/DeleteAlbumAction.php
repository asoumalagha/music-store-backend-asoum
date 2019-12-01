<?php

declare(strict_types=1);

namespace Asoum\Album\Action;

use Asoum\Album\Model\AlbumModel;
use Slim\Http\Request;
use Slim\Http\Response;

class DeleteAlbumAction
{
    private $albumModel;

    public function __construct(AlbumModel $albumModel)
    {
        $this->albumModel = $albumModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = $this->albumModel->deleteAlbum((int)$args['id']);
        return $response->withJson(['success' => $result]);
    }
}