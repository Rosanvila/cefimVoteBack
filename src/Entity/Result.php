<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ApiResource]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Principal = null;

    #[ORM\Column(length: 255)]
    private ?string $Secondary = null;

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
}
