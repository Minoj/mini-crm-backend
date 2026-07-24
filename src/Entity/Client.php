<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\ClientCreateAction;
use App\DTO\ClientDTO;
use App\Repository\ClientRepository;
use App\State\ClientCollectionProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            provider: ClientCollectionProvider::class,
        ),
        new Get(
            security: "object.getAssignedManager() == user || is_granted('ROLE_ADMIN')"
        ),
        new Post(
            uriTemplate: '/client',
            controller: ClientCreateAction::class,
            input: ClientDTO::class,
            name: 'clientCreate',
        ),
        new Patch(
            security: "object.getAssignedManager() == user || is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "object.getAssignedManager() == user || is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:write']],
)]
#[ORM\UniqueConstraint(name: 'UNIQ_CLIENT_EMAIL', fields: ['email'])]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Name not is required')]
    #[Groups(['client:read', 'client:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Phone number is required')]
    #[Assert\Regex(pattern: '/^\+[1-9]\d{7,14}$/')]
    #[Groups(['client:read', 'client:write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Email is required')]
    #[Groups(['client:read', 'client:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read', 'client:write'])]
    private ?string $company = null;

    #[ORM\ManyToOne()]
    #[Groups(['client:read', 'user:read'])]
    private ?User $assignedManager = null;

    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Deal>
     */
    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'client')]
    private Collection $deals;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getAssignedManager(): ?User
    {
        return $this->assignedManager;
    }

    public function setAssignedManager(?User $assignedManager): static
    {
        $this->assignedManager = $assignedManager;

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

    /**
     * @return Collection<int, Deal>
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): static
    {
        if (!$this->deals->contains($deal)) {
            $this->deals->add($deal);
            $deal->setClient($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): static
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getClient() === $this) {
                $deal->setClient(null);
            }
        }

        return $this;
    }
}
