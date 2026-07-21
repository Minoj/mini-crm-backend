<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
readonly class DealDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Groups(['deal:write'])]
        public int $clientId,

        #[Assert\NotBlank]
        #[Groups(['deal:write'])]
        public string $title,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[Groups(['deal:write'])]
        public float $amount,
    ) {
    }
}
