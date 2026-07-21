<?php

namespace App\Controller;

use App\Component\Client\ClientFactory;
use App\Component\Client\ClientManager;
use App\DTO\ClientDTO;
use App\Entity\Client;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

class ClientCreateAction extends AbstractController
{
    public function __construct(
        private ClientFactory $clientFactory,
        private ClientManager $clientManager,
        private Security $security
    )
    {
    }

    public function __invoke(ClientDTO $data): Client
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $client = $this->clientFactory->create($data, $user);

        $this->clientManager->save($client, true);

        return $client;
    }
}
