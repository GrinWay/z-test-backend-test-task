<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\TenderRepository;
use App\Type\Tender\TenderStateEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use GrinWay\Service\Trait\Doctrine\CreatedAt;
use GrinWay\Service\Trait\Doctrine\UpdatedAt;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TenderRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
    ],
    normalizationContext: [
        'groups' => 'tender:read',
    ],
    denormalizationContext: [
        'groups' => 'tender:write',
    ],
//    security: 'is_granted("IS_AUTHENTICATED")',
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'createdAt' => SearchFilterInterface::STRATEGY_IPARTIAL,
        'updatedAt' => SearchFilterInterface::STRATEGY_IPARTIAL,
    ]
)]
class Tender
{
    use CreatedAt;
    use UpdatedAt;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tender:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    #[Groups(['tender:read'])]
    protected ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['tender:read'])]
    protected ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tender:read', 'tender:write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['tender:read', 'tender:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tender:read', 'tender:write'])]
    private ?string $number = null;

    #[ORM\Column(enumType: TenderStateEnum::class)]
    #[Groups(['tender:read'])]
    private TenderStateEnum|null $state = null;

    #[ORM\Column]
    #[Groups(['tender:read', 'tender:write'])]
    private bool $isPublished = false;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getState(): TenderStateEnum|null
    {
        return $this->state;
    }

    public function setState(TenderStateEnum $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
