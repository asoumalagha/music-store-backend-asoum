<?php

declare(strict_types=1);

namespace Asoum\Song\Action;


use Asoum\Song\Model\SongModel;
use Slim\Http\Request;
use Slim\Http\Response;

class UpdateSongAction
{
    private $songModel;

    public function __construct(SongModel $songModel)
    {
        $this->songModel = $songModel;
    }
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->songModel->updateSong(
            (int)$args['id'],
            $jsonData['name'],
            (int)$jsonData['albumId']
        );
        return $response->withJson(['success' => $result]);
    }
}