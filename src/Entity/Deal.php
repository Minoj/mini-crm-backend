<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\DealCreateAction;
use App\DTO\DealDTO;
use App\Repository\DealRepository;
use App\State\DealCollectionProvider;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DealRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            provider: DealCollectionProvider::class,
        ),
        new Post(
            uriTemplate: '/deals/my',
            controller: DealCreateAction::class,
            input: DealDTO::class,
            name: 'dealCreate',
        ),
        new Get(
            security: "object.getCreatedBy() == user || is_granted('ROLE_ADMIN')"
        ),
        new Patch(
            security: "object.getCreatedBy() == user || is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "object.getCreatedBy() == user || is_granted('ROLE_ADMIN')"
        ),
    ],
    normalizationContext: ['groups' => ['deal:read']],
    denormalizationContext: ['groups' => ['deal:write']],
)]
class Deal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['deal:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['deal:read', 'deal:write'])]
    #[Assert\NotNull(message: 'Client not null')]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Title not is required')]
    #[Groups(['deal:read', 'deal:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['deal:read', 'deal:write'])]
    #[Assert\Positive()]
    private ?string $amount = null;

    #[ORM\Column(length: 255)]
    #[Groups(['deal:read'])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'deals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['deal:read'])]
    private ?User $createdBy = null;

    #[ORM\Column]
    #[Groups(['deal:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
