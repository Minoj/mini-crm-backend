<?php

namespace App\Controller;

use App\DTO\ChangeRoleDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserChangeRoleAction extends AbstractController
{
//    #[Route('/api/users/{id}/role', name: 'api_users_change_role', methods: ['PATCH'])]
//    #[IsGranted('ROLE_ADMIN')]
    public function __invoke(
        User $user,
        ChangeRoleDTO $data,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user->setRoles([$data->role]);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $user->getId(),
            'roles' => $user->getRoles(),
        ]);
    }
}
