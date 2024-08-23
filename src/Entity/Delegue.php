<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DeleguesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: DeleguesRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['delegue:read']],
    denormalizationContext: ['groups' => ['delegue:write']]
)]
class Delegue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['delegue:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['delegue:read', 'delegue:write'])]
    private ?string $Principal = null;

    #[ORM\Column(length: 255)]
    #[Groups(['delegue:read', 'delegue:write'])]
    private ?string $Second = null;

    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'DeleguesVotes')]
    #[Groups(['delegue:read'])]
    private Collection $DeleguesVotes;

    #[ORM\ManyToOne(inversedBy: 'SessionDelegate')]
    #[Groups(['delegue:read', 'delegue:write'])]
    private ?Session $DelegueSession = null;

    public function __construct()
    {
        $this->DeleguesVotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrincipal(): ?string
    {
        return $this->Principal;
    }

    public function setPrincipal(?string $Principal): static
    {
        $this->Principal = $Principal;

        return $this;
    }

    public function getSecond(): ?string
    {
        return $this->Second;
    }

    public function setSecond(string $Second): static
    {
        $this->Second = $Second;

        return $this;
    }

    public function getDeleguesVotes(): Collection
    {
        return $this->DeleguesVotes;
    }

    public function addDeleguesVote(Vote $deleguesVote): static
    {
        if (!$this->DeleguesVotes->contains($deleguesVote)) {
            $this->DeleguesVotes->add($deleguesVote);
            $deleguesVote->setDeleguesVotes($this);
        }

        return $this;
    }

    public function removeDeleguesVote(Vote $deleguesVote): static
    {
        if ($this->DeleguesVotes->removeElement($deleguesVote)) {
            // set the owning side to null (unless already changed)
            if ($deleguesVote->getDeleguesVotes() === $this) {
                $deleguesVote->setDeleguesVotes(null);
            }
        }

        return $this;
    }

    public function getDelegueSession(): ?Session
    {
        return $this->DelegueSession;
    }

    public function setDelegueSession(?Session $DelegueSession): static
    {
        $this->DelegueSession = $DelegueSession;

        return $this;
    }
}