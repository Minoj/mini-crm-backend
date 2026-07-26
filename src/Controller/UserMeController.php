<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserMeController extends AbstractController
{
    public function __invoke(): \Symfony\Component\Security\Core\User\UserInterface
    {
        return $this->getUser();
    }
}
