<?php

declare(strict_types=1);

namespace Asoum\Album\Action;

use Asoum\Album\Model\AlbumModel;
use Slim\Http\Request;
use Slim\Http\Response;

class AddNewAlbumAction
{
    private $albumModel;

    public function __construct(AlbumModel $albumModel)
    {
        $this->albumModel = $albumModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->albumModel->addNewAlbum(
            $jsonData['name'],
            (int)$jsonData['bandId']
        );
        return $response->withJson(['success' => $result]);
    }
}