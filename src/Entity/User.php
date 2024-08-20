<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $nom = null;

    #[ORM\Column(length: 45)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $signature = null;

    #[ORM\Column(nullable: true)]
    private ?bool $delegue = null;

    #[ORM\Column(nullable: true)]
    private ?bool $suppleant = null;

    #[ORM\ManyToOne(inversedBy: 'SessionUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $UsersSession = null;

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
}
