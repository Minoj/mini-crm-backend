<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

readonly class RegisterDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Groups(['user:write'])]
        public string $email,

        #[Assert\NotBlank]
        #[Groups(['user:write'])]
        public string $password,

        #[Assert\NotBlank]
        #[Groups(['user:write'])]
        public string $name,
    ) {
    }
}
