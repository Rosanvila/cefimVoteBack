<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(inversedBy: 'AdminSession')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Admin $SessionAdmin = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Result $SessionResult = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'UsersSession')]
    private Collection $SessionUsers;

    public function __construct()
    {
        $this->SessionUsers = new ArrayCollection();
    }

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

    public function getSessionAdmin(): ?Admin
    {
        return $this->SessionAdmin;
    }

    public function setSessionAdmin(?Admin $SessionAdmin): static
    {
        $this->SessionAdmin = $SessionAdmin;

        return $this;
    }

    public function getSessionResult(): ?Result
    {
        return $this->SessionResult;
    }

    public function setSessionResult(Result $SessionResult): static
    {
        $this->SessionResult = $SessionResult;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSessionUsers(): Collection
    {
        return $this->SessionUsers;
    }

    public function addSessionUser(User $sessionUser): static
    {
        if (!$this->SessionUsers->contains($sessionUser)) {
            $this->SessionUsers->add($sessionUser);
            $sessionUser->setUsersSession($this);
        }

        return $this;
    }

    public function removeSessionUser(User $sessionUser): static
    {
        if ($this->SessionUsers->removeElement($sessionUser)) {
            // set the owning side to null (unless already changed)
            if ($sessionUser->getUsersSession() === $this) {
                $sessionUser->setUsersSession(null);
            }
        }

        return $this;
    }
}