<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: VoteRepository::class)]

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['vote:read']],
    denormalizationContext: ['groups' => ['vote:write']]
)]

class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'VoteUsers', cascade: ['persist', 'remove'])]
    #[Groups(['vote:read', 'vote:write'])]
    private ?User $UsersVote = null;

    #[ORM\ManyToOne(inversedBy: 'DeleguesVotes')]
    #[Groups(['vote:read', 'vote:write'])]
    private ?Delegue $DeleguesVotes = null;

    #[ORM\ManyToOne(inversedBy: 'ResultVotes')]
    #[Groups(['vote:read'])]
    private ?Result $VotesResult = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersVote(): ?User
    {
        return $this->UsersVote;
    }

    public function setUsersVote(?User $UsersVote): static
    {
        $this->UsersVote = $UsersVote;

        return $this;
    }

    public function getDeleguesVotes(): ?Delegue
    {
        return $this->DeleguesVotes;
    }

    public function setDeleguesVotes(?Delegue $DeleguesVotes): static
    {
        $this->DeleguesVotes = $DeleguesVotes;

        return $this;
    }

    public function getVotesResult(): ?Result
    {
        return $this->VotesResult;
    }

    public function setVotesResult(?Result $VotesResult): static
    {
        $this->VotesResult = $VotesResult;

        return $this;
    }
}