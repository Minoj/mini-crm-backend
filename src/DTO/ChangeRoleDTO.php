<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeRoleDTO
{
    #[Assert\NotBlank]
    #[Groups(['user:role:write'])]
    public string $role;
}
