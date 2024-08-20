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
}
