<?php

namespace App\Component\Deal;

use App\DTO\DealDTO;
use App\Entity\Client;
use App\Entity\Deal;
use App\Entity\User;

class DealFactory
{
    public function create(
        DealDTO $dealDTO,
        User $user,
        Client $client,
    ): Deal
    {
        $deal = new Deal();
        $deal->setTitle($dealDTO->title);
        $deal->setClient($client);
        $deal->setAmount($dealDTO->amount);
        $deal->setStatus('new');
        $deal->setCreatedBy($user);
        $deal->setCreatedAt(new \DateTimeImmutable());

        return $deal;
    }
}
