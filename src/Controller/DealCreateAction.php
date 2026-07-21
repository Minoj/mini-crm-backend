<?php

namespace App\Controller;

use App\Component\Deal\DealFactory;
use App\Component\Deal\DealManager;
use App\DTO\DealDTO;
use App\Entity\Client;
use App\Entity\Deal;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DealCreateAction extends AbstractController
{
    public function __construct(
        private DealFactory $dealFactory,
        private DealManager $dealManager,
        private ClientRepository $clientRepository,
    ) {
    }

    public function __invoke(DealDTO $data): Deal
    {
        $client = $this->clientRepository->find($data->clientId);

        if (!$client instanceof Client) {
            throw $this->createNotFoundException('Client not found');
        }

        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $deal = $this->dealFactory->create($data, $user, $client);

        $this->dealManager->save($deal, true);

        return $deal;
    }
}
