<?php


namespace Asoum\Song\Action;


use Asoum\Song\Model\SongModel;
use Slim\Http\Request;
use Slim\Http\Response;

class DeleteSongFromUser
{
    private $songModel;

    public function __construct(SongModel $songModel)
    {
        $this->songModel = $songModel;
    }
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $jsonData = $request->getParsedBody();
        $result = $this->songModel->deleteSongFromUser(
            (int)$args['id'],
            (int)$jsonData['song']
        );
        return $response->withJson(['success' => $result]);
    }
}