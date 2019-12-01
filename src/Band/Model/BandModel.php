<?php

declare(strict_types=1);

namespace Asoum\Band\Model;


use Asoum\Band\Entity\BandEntity;
use Asoum\Band\Repository\BandRepository;
use Psr\Log\LoggerInterface;

class BandModel
{
    private $logger;
    private $bandRepository;

    public function __construct(LoggerInterface $logger, BandRepository $bandRepository)
    {
        $this->logger = $logger;
        $this->bandRepository = $bandRepository;
    }

    public function getAllBand(): array
    {
        $result = $this->bandRepository->getAllBand();
        $this->logger->info('All bands are sent to response');
        return $result;
    }

    public function getBandById(int $id): ?BandEntity
    {
        $result = $this->bandRepository->getBandById($id);
        $this->logger->info('Band with id ' . $id . ' found');
        return $result;
    }

    public function getBandByPersonId(int $id): array
    {
        $result = $this->bandRepository->getBandByPersonId($id);
        $this->logger->info('Person ' . $id . 's bands are found');
        return $result;
    }

    public function addNewBand(string $name): bool
    {
        $this->bandRepository->addNewBand($name);
        $this->logger->info('New band ' . $name . ' is added');
        return true;
    }

    public function addPersonToBand(int $id, int $person): bool
    {
        $this->bandRepository->addPersonToBand($id, $person);
        $this->logger->info('Person ' . $person . 'added to band ' . $id);
        return true;
    }

    public function updateBand(int $id, string $name): bool
    {
        $this->bandRepository->updateBand($id, $name);
        $this->logger->info('Band with id ' . $id . ' is modified to ' . $name);
        return true;
    }

    public function deleteBand(int $id): bool
    {
        $this->bandRepository->deleteBand($id);
        $this->logger->info('Band with id ' . $id . ' has been deleted');
        return true;
    }

    public function deletePersonFromBand(int $id, int $person): bool
    {
        $this->bandRepository->deletePersonFromBand($id, $person);
        $this->logger->info('Person ' . $person . 'deleted from band ' . $id);
        return true;
    }
}