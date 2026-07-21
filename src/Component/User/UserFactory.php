<?php

namespace App\Component\User;

use App\DTO\RegisterDTO;
use App\Entity\User;

class UserFactory
{
    public function create(
        RegisterDTO $registerDTO,
        string $hashedPassword,
    ): User
    {
        $user = new User();
        $user->setEmail($registerDTO->email);
        $user->setName($registerDTO->name);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
