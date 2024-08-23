<?php
namespace App\Entity;

use ApiPlatform\Doctrine\Odm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Elasticsearch\Filter\MatchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            controller: UserController::class,
        ),
        new Put(),
        new Patch(),
        new Delete(),
    ],
            normalizationContext: ['groups' => ['user:read']],
            denormalizationContext: ['groups' => ['user:write']]
)]
#[ApiFilter(BooleanFilter::class, properties: ['HasVoted'])]
#[ApiFilter(SearchFilter::class, properties: ['UsersSession' => 'exact'])]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 45)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $signature = null;

    #[ORM\Column(nullable: true)]
    private ?bool $delegue = null;

    #[ORM\Column(nullable: true)]
    private ?bool $suppleant = null;

    #[ORM\ManyToOne(inversedBy: 'SessionUsers')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    private ?Session $UsersSession = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['user:read', 'user:write'])]
    private ?bool $HasVoted = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    public function isDelegue(): ?bool
    {
        return $this->delegue;
    }

    public function setDelegue(?bool $delegue): static
    {
        $this->delegue = $delegue;

        return $this;
    }

    public function isSuppleant(): ?bool
    {
        return $this->suppleant;
    }

    public function setSuppleant(?bool $suppleant): static
    {
        $this->suppleant = $suppleant;

        return $this;
    }

    public function getUsersSession(): ?Session
    {
        return $this->UsersSession;
    }

    public function setUsersSession(?Session $UsersSession): static
    {
        $this->UsersSession = $UsersSession;

        return $this;
    }

    public function getHasVoted(): ?bool
    {
        return $this->HasVoted;
    }

    public function setHasVoted(?bool $HasVoted): static
    {
        $this->HasVoted = $HasVoted;

        return $this;
    }
}