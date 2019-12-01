<?php

declare(strict_types=1);

namespace Asoum\Album\Repository;


use Asoum\Album\Entity\AlbumEntity;
use PDO;

class AlbumRepository
{
    private $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getAllAlbum(): array
    {
        $query = $this->database->prepare('SELECT * FROM album');
        $query->execute();
        $albums = $query->fetchAll();
        return $this->createAlbumEntities($albums);
    }

    public function getAlbumById(int $id): ?AlbumEntity
    {
        $query = $this->database->prepare('SELECT * FROM album WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $album = $query->fetch();
        if (!$album) {
            return null;
        }
        return $this->createAlbumEntity($album);
    }

    public function addNewAlbum(string $name, int $bandId): void
    {
        $query = $this->database->prepare('INSERT INTO album (name, band_id) VALUES (:name, :bandId)');
        $query->bindParam('name', $name);
        $query->bindParam('bandId', $bandId);
        $query->execute();
    }

    public function updateAlbum(int $id, $name, int $bandId): void
    {
        $query = $this->database->prepare('UPDATE album SET name=:name, band_id=:bandId WHERE id=:id');
        $query->bindParam('id', $id);
        $query->bindParam('name', $name);
        $query->bindParam('bandId', $bandId);
        $query->execute();

    }

    public function deleteAlbum(int $id): void
    {
        $query = $this->database->prepare(
            'DELETE FROM song WHERE album_id=:id;
                      DELETE FROM album WHERE id=:id
                      ');
        $query->bindParam('id', $id);
        $query->execute();
    }

    private function createAlbumEntity(array $album): AlbumEntity
    {
        return new AlbumEntity(
            (int)$album['id'],
            $album['name'],
            (int)$album['band_id']
        );
    }

    private function createAlbumEntities(array $albumData): array
    {
        $results = [];
        foreach ($albumData as $album) {
            $results[] = $this->createAlbumEntity($album);
        }
        return $results;
    }

}