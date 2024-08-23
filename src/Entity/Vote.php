<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
#[ApiResource]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'VoteUsers', cascade: ['persist', 'remove'])]
    private ?User $UsersVote = null;

    #[ORM\ManyToOne(inversedBy: 'DeleguesVotes')]
    private ?Delegues $DeleguesVotes = null;

    #[ORM\ManyToOne(inversedBy: 'ResultVotes')]
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

    public function getDeleguesVotes(): ?Delegues
    {
        return $this->DeleguesVotes;
    }

    public function setDeleguesVotes(?Delegues $DeleguesVotes): static
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