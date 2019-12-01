<?php

declare(strict_types=1);

namespace Asoum\Person\Repository;

use Asoum\Person\Entity\PersonEntity;
use PDO;

class PersonRepository
{
    private $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getAllPerson(): array
    {
        $query = $this->database->prepare('SELECT * FROM person');
        $query->execute();
        $people = $query->fetchAll();
        return $this->createPersonEntities($people);
    }

    public function getPersonById(int $id): ?PersonEntity
    {
        $query = $this->database->prepare('SELECT * FROM person WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $person = $query->fetch();
        if (!$person) {
            return null;
        }
        return $this->createPersonEntity($person);
    }

    public function getPersonByBandId(int $id): array
    {
        $query = $this->database->prepare(
            'SELECT * FROM person 
                       INNER JOIN person_band 
                       ON person.id = person_band.person_id
                       WHERE person_band.band_id = :id
                       GROUP BY person.id'
        );
        $query->bindParam('id', $id);
        $query->execute();
        $persons = $query->fetchAll();
        return $this->createPersonEntities($persons);
    }

    public function addNewPerson(string $name): void
    {
        $query = $this->database->prepare('INSERT INTO person (name) VALUES (:name)');
        $query->bindParam('name', $name);
        $query->execute();
    }

    public function updatePerson(int $id, string $name): void
    {
        $query = $this->database->prepare('UPDATE person SET name=:name WHERE id=:id');
        $query->bindParam('id', $id);
        $query->bindParam('name', $name);
        $query->execute();
    }

    public function deletePerson(int $id): void
    {
        $query = $this->database->prepare(
            'DELETE FROM person_band WHERE person_id=:id;
                       DELETE FROM person WHERE id=:id;         
        ');
        $query->bindParam('id', $id);
        $query->execute();
    }


    private function createPersonEntity(array $person): PersonEntity
    {
        return new PersonEntity(
            (int)$person['id'],
            $person['name']
        );
    }

    private function createPersonEntities(array $personData): array
    {
        $results = [];
        foreach ($personData as $person) {
            $results[] = $this->createPersonEntity($person);
        }
        return $results;
    }


}