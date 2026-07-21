<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Client;
use App\Entity\Deal;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DealCollectionProvider implements ProviderInterface
{

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $collectionProvider,

        private Security $security,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {

        // 1. Avval standart Doctrine provider ishlaydi
        $result = $this->collectionProvider->provide(
            $operation,
            $uriVariables,
            $context
        );

        // 2. Login bo'lgan user
        $currentUser = $this->security->getUser();

        if (!$currentUser instanceof User) {
            return [];
        }

        // 3. Admin bo'lsa hammasini qaytar
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $result;
        }

        // 4. Oddiy user bo'lsa filter qil
        if (is_iterable($result)) {
            $items = iterator_to_array($result, false);

            return array_values(array_filter(
                $items,
                fn (Deal $deal) => $deal->getCreatedBy() === $currentUser
            ));
        }

        return $result;
    }
}
