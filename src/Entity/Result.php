<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['result:read']],
    denormalizationContext: ['groups' => ['result:write']]
)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['result:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['result:read', 'result:write'])]
    private ?string $Principal = null;

    #[ORM\Column(length: 255)]
    #[Groups(['result:read', 'result:write'])]
    private ?string $Secondary = null;

    #[ORM\OneToOne(inversedBy: 'SessionResultEnd', cascade: ['persist', 'remove'])]
    #[Groups(['result:read', 'result:write'])]
    private ?Session $ResultSession = null;

    /**
     * @var Collection<int, Vote>
     */
    #[ORM\OneToMany(targetEntity: Vote::class, mappedBy: 'VotesResult')]
    #[Groups(['result:read'])]
    private Collection $ResultVotes;

    public function __construct()
    {
        $this->ResultVotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrincipal(): ?string
    {
        return $this->Principal;
    }

    public function setPrincipal(string $Principal): static
    {
        $this->Principal = $Principal;

        return $this;
    }

    public function getSecondary(): ?string
    {
        return $this->Secondary;
    }

    public function setSecondary(string $Secondary): static
    {
        $this->Secondary = $Secondary;

        return $this;
    }

    public function getResultSession(): ?Session
    {
        return $this->ResultSession;
    }

    public function setResultSession(?Session $ResultSession): static
    {
        $this->ResultSession = $ResultSession;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getResultVotes(): Collection
    {
        return $this->ResultVotes;
    }

    public function addResultVote(Vote $resultVote): static
    {
        if (!$this->ResultVotes->contains($resultVote)) {
            $this->ResultVotes->add($resultVote);
            $resultVote->setVotesResult($this);
        }

        return $this;
    }

    public function removeResultVote(Vote $resultVote): static
    {
        if ($this->ResultVotes->removeElement($resultVote)) {
            // set the owning side to null (unless already changed)
            if ($resultVote->getVotesResult() === $this) {
                $resultVote->setVotesResult(null);
            }
        }

        return $this;
    }

    public function getVoteCount(): int
    {
        return $this->ResultVotes->count();
    }

    public function getDelegates(): array
    {
        $delegates = [];
        foreach ($this->ResultVotes as $vote) {
            $delegates[] = $vote->getDeleguesVotes();
        }
        return $delegates;
    }
}