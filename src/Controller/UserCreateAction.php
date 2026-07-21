<?php
namespace App\Controller;

use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\DTO\RegisterDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateAction extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function __construct(
        private UserFactory $userFactory,
        private UserManager $userManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterDTO $data): User
    {
        $hashedPassword = $this->passwordHasher->hashPassword(new User(), $data->password);
        $user = $this->userFactory->create($data, $hashedPassword);
        $this->userManager->save($user, true);

        return $user;
    }
}
