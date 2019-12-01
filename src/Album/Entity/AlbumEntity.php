<?php

declare(strict_types=1);

namespace Asoum\Album\Entity;


use JsonSerializable;

class AlbumEntity implements JsonSerializable
{
    private $id;
    private $name;
    private $band_id;

    public function __construct(int $id, string $name, int $band_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->band_id = $band_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBandId(): int
    {
        return $this->band_id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'band_id' => $this->getBandId()
        ];
    }
}