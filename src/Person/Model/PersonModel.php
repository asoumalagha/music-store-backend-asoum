<?php

declare(strict_types=1);


namespace Asoum\Person\Model;

use Asoum\Person\Entity\PersonEntity;
use Asoum\Person\Repository\PersonRepository;
use Psr\Log\LoggerInterface;


class PersonModel
{
    private $logger;
    private $personRepository;

    public function __construct(LoggerInterface $logger, PersonRepository $personRepository)
    {
        $this->logger = $logger;
        $this->personRepository = $personRepository;
    }

    public function getAllPerson(): array
    {
        $result = $this->personRepository->getAllPerson();
        $this->logger->info('All people are sent to response');
        return $result;
    }

    public function getPersonById(int $id): ?PersonEntity
    {
        $result = $this->personRepository->getPersonById($id);
        $this->logger->info('Person with id ' . $id . ' found');
        return $result;
    }

    public function addNewPerson(string $name): bool
    {
        $this->personRepository->addNewPerson($name);
        $this->logger->info('New person ' . $name . ' is added');
        return true;
    }

    public function updatePerson(int $id, string $name): bool
    {
        $this->personRepository->updatePerson($id, $name);
        $this->logger->info('Person with id ' . $id . ' is modified to ' . $name);
        return true;
    }

    public function deletePerson(int $id): bool
    {
        $this->personRepository->deletePerson($id);
        $this->logger->info('Person with id ' . $id . ' has been deleted');
        return true;
    }

    public function getPersonByBandId(int $id): array
    {
        $result = $this->personRepository->getPersonByBandId($id);
        $this->logger->info('Band ' . $id . 's members are found');
        return $result;
    }
}