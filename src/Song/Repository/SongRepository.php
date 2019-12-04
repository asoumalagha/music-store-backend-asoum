<?php

declare(strict_types=1);

namespace Asoum\Song\Repository;


use Asoum\Song\Entity\SongEntity;
use PDO;

class SongRepository
{
    private $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getAllSong(): array
    {
        $query = $this->database->prepare('SELECT * FROM song');
        $query->execute();
        $songs = $query->fetchAll();
        return $this->createSongEntities($songs);
    }

    public function getSongById(int $id): ?SongEntity
    {
        $query = $this->database->prepare('SELECT * FROM song WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $song = $query->fetch();
        if (!$song) {
            return null;
        }
        return $this->createSongEntity($song);
    }

    public function getSongByAlbumId(int $albumId): array
    {
        $query = $this->database->prepare('SELECT * FROM song WHERE album_id=:albumId');
        $query->bindParam('albumId', $albumId);
        $query->execute();
        $songs = $query->fetchAll();
        return $this->createSongEntities($songs);
    }

    public function addNewSong(string $name, int $albumId): void
    {
        $query = $this->database->prepare('INSERT INTO song (name, album_id) VALUES (:name, :albumId)');
        $query->bindParam('name', $name);
        $query->bindParam('albumId', $albumId);
        $query->execute();
    }

    public function updateSong(int $id, string $name, int $albumId): void
    {
        $query = $this->database->prepare('UPDATE song SET name=:name, album_id=:albumId WHERE id=:id');
        $query->bindParam('id', $id);
        $query->bindParam('name', $name);
        $query->bindParam('albumId', $albumId);
        $query->execute();
    }


    public function deleteSong(int $id): void
    {
        $query = $this->database->prepare('DELETE FROM song WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
    }

    public function addSongToUser(int $id, int $song): void
    {
        $query = $this->database->prepare('INSERT INTO user_song(user_id, song_id) VALUES (:user, :song)');
        $query->bindParam('user', $id);
        $query->bindParam('song', $song);
        $query->execute();
    }

    public function deleteSongFromUser(int $id, int $song): void
    {
        $query = $this->database->prepare('DELETE FROM user_song WHERE user_id=:id AND song_id=:song;');
        $query->bindParam('id', $id);
        $query->bindParam('song', $song);
        $query->execute();
    }

    public function getSongByUserId(int $id): array
    {
        $query = $this->database->prepare(
            'SELECT * FROM song 
                       INNER JOIN user_song 
                       ON song.id = user_song.song_id
                       WHERE user_song.user_id = :id
                       GROUP BY song.id'
        );
        $query->bindParam('id', $id);
        $query->execute();
        $songs = $query->fetchAll();
        return $this->createSongEntities($songs);
    }

    private function createSongEntity(array $song): SongEntity
    {
        return new SongEntity(
            (int)$song['id'],
            $song['name'],
            (int)$song['album_id']
        );
    }

    private function createSongEntities(array $songData): array
    {
        $results = [];
        foreach ($songData as $song) {
            $results[] = $this->createSongEntity($song);
        }
        return $results;
    }


}