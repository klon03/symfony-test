<?php

declare(strict_types=1);

namespace App\Tests;

use App\Services\UserService;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserServiceTest extends TestCase
{
    public function testAddUser()
    {
        // Create a mock of the UserRepository
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('findOneBy')->willReturn(null);
        $userRepository->method('insert')->willReturn(10);

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher->method('hashPassword')->willReturn('hashed_password');

        $userService = new UserService($userRepository, $passwordHasher);

        $data = [
            'username' => 'test_username',
            'password' => 'test_password',
        ];

        $result = $userService->addUser($data);
        $expectedResult = [
            'insertId' => null,
        ];

        $this->assertEquals($expectedResult, $result);
    }
}
