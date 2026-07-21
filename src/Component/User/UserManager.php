<?php

namespace App\Component\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function save(User $user, bool $isNeedFlush = false):void
    {
        $this->entityManager->persist($user);

        if ($isNeedFlush) {
            $this->entityManager->flush();
        }
    }

    public function hashPassword(User $user, string $password): void
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $password));
    }
}
