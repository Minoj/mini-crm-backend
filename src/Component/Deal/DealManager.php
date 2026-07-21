<?php

namespace App\Component\Deal;

use App\Entity\Deal;
use Doctrine\ORM\EntityManagerInterface;

class DealManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Deal $deal, bool $isNeedFlush = false): void
    {
        $this->entityManager->persist($deal);

        if ($isNeedFlush) {
            $this->entityManager->flush();
        }
    }
}
