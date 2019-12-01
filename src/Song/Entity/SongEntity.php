<?php

declare(strict_types=1);

namespace Asoum\Song\Entity;


use JsonSerializable;

class SongEntity implements JsonSerializable
{
    private $id;
    private $name;
    private $album_id;

    public function __construct(int $id, string $name, int $album_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->album_id = $album_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlbumId(): int
    {
        return $this->album_id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'album_id' => $this->getAlbumId()
        ];
    }
}