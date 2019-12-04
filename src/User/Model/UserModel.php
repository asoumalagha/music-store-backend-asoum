<?php

declare(strict_types=1);

namespace Asoum\User\Model;


use Asoum\Song\Entity\SongEntity;
use Asoum\Song\Repository\SongRepository;
use Asoum\User\Entity\UserEntity;
use Asoum\User\Repository\UserRepository;
use Psr\Log\LoggerInterface;

class UserModel
{
    private $logger;
    private $userRepository;

    public function __construct(LoggerInterface $logger, UserRepository $userRepository)
    {
        $this->logger = $logger;
        $this->userRepository = $userRepository;
    }

    public function getUserById(int $id): ?UserEntity
    {
        $result = $this->userRepository->getUserById($id);
        $this->logger->info('User with id ' . $id . ' found');
        return $result;
    }

    public function addNewUser(string $name, string $email, string $password): bool
    {
        $this->userRepository->addNewUser($name, $email, $password);
        $this->logger->info('New user ' . $name . ' is added. ');
        return true;
    }

    public function updateUser(int $id,string $name, string $email, string $password): bool
    {
        $this->userRepository->updateUser($id, $name, $email, $password);
        $this->logger->info('User with id ' . $id . ' name is modified to ' . $name.' and email '.$email .'and password '.$password);
        return true;
    }

    public function deleteUser(int $id): bool
    {
        $this->userRepository->deleteUser($id);
        $this->logger->info('User ' . $id . 'is deleted.');
        return true;
    }
}