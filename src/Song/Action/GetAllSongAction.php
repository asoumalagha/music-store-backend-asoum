<?php

declare(strict_types=1);

namespace Asoum\Song\Action;


use Asoum\Song\Model\SongModel;
use Slim\Http\Request;
use Slim\Http\Response;

class GetAllSongAction
{
    private $songModel;

    public function __construct(SongModel $songModel)
    {
        $this->songModel = $songModel;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $result = $this->songModel->getAllSong();
        return $response->withJson($result);
    }
}