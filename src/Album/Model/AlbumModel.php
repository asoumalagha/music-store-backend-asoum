<?php

declare(strict_types=1);

namespace Asoum\Album\Model;


use Asoum\Album\Entity\AlbumEntity;
use Asoum\Album\Repository\AlbumRepository;
use Psr\Log\LoggerInterface;

class AlbumModel
{
    private $logger;
    private $albumRepository;

    public function __construct(LoggerInterface $logger, AlbumRepository $albumRepository)
    {
        $this->logger = $logger;
        $this->albumRepository = $albumRepository;
    }

    public function getAllAlbum(): array
    {
        $result = $this->albumRepository->getAllAlbum();
        $this->logger->info('All albums are sent to response');
        return $result;
    }

    public function getAlbumById(int $id): ?AlbumEntity
    {
        $result = $this->albumRepository->getAlbumById($id);
        $this->logger->info('Album with id ' . $id . ' found');
        return $result;
    }

    public function addNewAlbum(string $name, int $bandId): bool
    {
        $this->albumRepository->addNewAlbum($name, $bandId);
        $this->logger->info('New album ' . $name . ' is added to band ' . $bandId);
        return true;
    }

    public function updateAlbum(int $id, $name, int $bandId): bool
    {
        $this->albumRepository->updateAlbum($id, $name, $bandId);
        $this->logger->info('Album has been updated with name '.$name.' and band '.$bandId);
        return true;
    }

    public function deleteAlbum(int $id): bool
    {
        $this->albumRepository->deleteAlbum($id);
        $this->logger->info('Album ' . $id . 'is deleted.');
        return true;
    }



}