<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function getUserData(UserInterface $user): array
    {
        return [
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "roles" => $user->getRoles(),
        ];
    }

    public function getOne(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function addUser(array $data): array
    {
        $existingUser = $this->userRepository->findOneBy(['username' => $data['username']]);

        if ($existingUser) {
            throw new \Exception("Nazwa użytkownika już istnieje");
        }

        $user = new User();
        $user->setUsername($data['username']);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);
        $this->userRepository->insert($user);

        return [
            "insertId" => $user->getId(),
        ];
    }

    public function removeUser(int $id): void
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            $this->userRepository->delete($user);
        }
    }

    public function updateUser(int $id, array $data): void
    {
        $user = $this->userRepository->find($id);

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['password'])) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        }

        $this->userRepository->update($user);
    }
}

