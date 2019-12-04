<?php

declare(strict_types=1);

namespace Asoum\User\Repository;



use Asoum\User\Entity\UserEntity;
use PDO;

class UserRepository
{
    private $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getUserById(int $id): ?UserEntity
    {
        $query = $this->database->prepare('SELECT * FROM user WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
        $user = $query->fetch();
        if (!$user) {
            return null;
        }
        return $this->createUserEntity($user);
    }

    public function addNewUser(string $name, string $email, string $password): void
    {
        $query = $this->database->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
        $query->bindParam('name', $name);
        $query->bindParam('email', $email);
        $query->bindParam('password', $password);
        $query->execute();
    }

    public function updateUser(int $id, string $name, string $email, string $password): void
    {
        $query = $this->database->prepare('UPDATE user SET name=:name, email=:email, password=:password WHERE id=:id');
        $query->bindParam('id', $id);
        $query->bindParam('name', $name);
        $query->bindParam('email', $email);
        $query->bindParam('password', $password);
        $query->execute();
    }

    public function deleteUser(int $id): void
    {
        $query = $this->database->prepare('DELETE FROM user WHERE id=:id');
        $query->bindParam('id', $id);
        $query->execute();
    }

    private function createUserEntity(array $user): UserEntity
    {
        return new UserEntity(
            (int)$user['id'],
            $user['name'],
            $user['email']
        );
    }
}