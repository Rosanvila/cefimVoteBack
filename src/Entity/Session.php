<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codesession = null;

    #[ORM\Column(length: 255)]
    private ?string $promotion = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $heureDebut = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodesession(): ?string
    {
        return $this->codesession;
    }

    public function setCodesession(string $codesession): static
    {
        $this->codesession = $codesession;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(string $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}