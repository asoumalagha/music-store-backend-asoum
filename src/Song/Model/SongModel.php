<?php

declare(strict_types=1);

namespace Asoum\Song\Model;


use Asoum\Song\Entity\SongEntity;
use Asoum\Song\Repository\SongRepository;
use Psr\Log\LoggerInterface;

class SongModel
{
    private $logger;
    private $songRepository;

    public function __construct(LoggerInterface $logger, SongRepository $songRepository)
    {
        $this->logger = $logger;
        $this->songRepository = $songRepository;
    }

    public function getAllSong(): array
    {
        $result = $this->songRepository->getAllSong();
        $this->logger->info('All songs are sent to response');
        return $result;
    }

    public function getSongById(int $id): ?SongEntity
    {
        $result = $this->songRepository->getSongById($id);
        $this->logger->info('Song with id ' . $id . ' found');
        return $result;
    }

    public function getSongByAlbumId(int $albumId): array
    {
        $result = $this->songRepository->getSongByAlbumId($albumId);
        $this->logger->info('Songs with album id ' . $albumId . ' found');
        return $result;
    }

    public function addNewSong(string $name, int $albumId): bool
    {
        $this->songRepository->addNewSong($name, $albumId);
        $this->logger->info('New song ' . $name . ' is added to album ' . $albumId);
        return true;
    }

    public function updateSong(int $id, string $name, int $albumId): bool
    {
        $this->songRepository->updateSong($id, $name, $albumId);
        $this->logger->info('Album with id ' . $id . ' name is modified to ' . $name.' and album id '.$albumId);
        return true;
    }


    public function deleteSong(int $id): bool
    {
        $this->songRepository->deleteSong($id);
        $this->logger->info('Song ' . $id . 'is deleted.');
        return true;
    }
}