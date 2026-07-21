<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
readonly class ClientDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Groups(['client:write'])]
        public string $name,

        #[Assert\NotBlank]
        #[Groups(['client:write'])]
        public string $phone,

        #[Assert\NotBlank]
        #[Assert\Email]
        #[Groups(['client:write'])]
        public string $email,

        #[Assert\NotBlank]
        #[Groups(['client:write'])]
        public string $company,
    ) {
    }
}
