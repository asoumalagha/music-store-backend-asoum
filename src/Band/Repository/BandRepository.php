<?php

declare(strict_types=1);

namespace Asoum\Band\Repository;


use Asoum\Band\Entity\BandEntity;
use PDO;

class BandRepository
{
    private $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getAllBand(): array
    {
        $query = $this->database->prepare('SELECT * FROM band');
        $query->execute();
        $bands = $query->fetchAll();
        return $this->createBandEntities($bands);
    }

    public function getBandById(int $id): ?BandEntity
    {
        $query = $this->database->prepare('SELECT * FROM band WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $band = $query->fetch();
        return $this->createBandEntity($band);
    }

    public function getBandByPersonId(int $id): array
    {
        $query = $this->database->prepare(
            'SELECT * FROM band 
                       INNER JOIN person_band 
                       ON band.id = person_band.band_id
                       WHERE person_band.person_id = :id
                       GROUP BY band.id'
        );
        $query->bindParam('id', $id);
        $query->execute();
        $bands = $query->fetchAll();
        return $this->createBandEntities($bands);
    }

    public function addNewBand(string $name): void
    {
        $query = $this->database->prepare('INSERT INTO band (name) VALUES (:name)');
        $query->bindParam('name', $name);
        $query->execute();
    }

    public function addPersonToBand(int $id, int $person): void
    {
        $query = $this->database->prepare('INSERT INTO person_band(person_id, band_id) VALUES (:person, :id)');
        $query->bindParam('person', $person);
        $query->bindParam('id', $id);
        $query->execute();
    }

    public function updateBand(int $id, string $name): void
    {
        $query = $this->database->prepare('UPDATE band SET name=:name WHERE id=:id');
        $query->bindParam('id', $id);
        $query->bindParam('name', $name);
        $query->execute();
    }

    public function deleteBand(int $id): void
    {
        $query = $this->database->prepare(
            'DELETE FROM album WHERE band_id=:id;
                       DELETE FROM person_band WHERE band_id=:id; 
                       DELETE FROM band WHERE id=:id
                       ');
        $query->bindParam('id', $id);
        $query->execute();

    }

    public function deletePersonFromBand(int $id, int $person): void
    {
        $query = $this->database->prepare('DELETE FROM person_band WHERE band_id=:id AND person_id=:person');
        $query->bindParam('person', $person);
        $query->bindParam('id', $id);
        $query->execute();
        if (!$this->findBandInJunction((int)$id)) {
            $this->deleteBand((int)$id);
        }
    }

    private function createBandEntities(array $bandData): array
    {
        $results = [];
        foreach ($bandData as $band) {
            $results[] = $this->createBandEntity($band);
        }
        return $results;
    }

    private function createBandEntity(array $band): BandEntity
    {
        return new BandEntity(
            (int)$band['id'],
            $band['name']
        );
    }

    private function findBandInJunction(int $id): array
    {
        $query = $this->database->prepare('SELECT * FROM person_band WHERE band_id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }


}