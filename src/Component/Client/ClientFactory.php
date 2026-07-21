<?php

namespace App\Component\Client;

use App\DTO\ClientDTO;
use App\Entity\Client;
use App\Entity\User;

class ClientFactory
{
    public function create(
        ClientDTO $clientDTO,
        User $user,
    ): Client
    {
        $client = new Client();
        $client->setName($clientDTO->name);
        $client->setEmail($clientDTO->email);
        $client->setPhone($clientDTO->phone);
        $client->setCompany($clientDTO->company);
        $client->setCreatedAt(new \DateTimeImmutable());
        $client->setAssignedManager($user);

        return $client;
    }
}
