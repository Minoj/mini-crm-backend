<?php

namespace App\Component\Client;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Client $client, bool $isNeedFlush = false): void
    {
        $this->entityManager->persist($client);

        if ($isNeedFlush) {
            $this->entityManager->flush();
        }
    }
}
