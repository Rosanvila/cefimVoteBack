<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\SessionController;
use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/session/{codesession}',
            uriVariables: ['codesession'],
            controller: SessionController::class,
            read: false,
            name: 'get_session_code'
        ),
        new GetCollection(),
        new Delete(),
        new Post(
            normalizationContext: ['groups' => ['session:read']],
            denormalizationContext: ['groups' => ['session:write']]
        ),
        new Patch(),
        New Put(),
        ],
)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[groups(['session:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[groups(['session:read', 'session:write'])]
    private ?string $codesession = null;

    #[ORM\Column(length: 255)]
    #[groups(['session:read', 'session:write'])]
    private ?string $promotion = null;

    #[ORM\Column(type: 'datetime')]
    #[groups(['session:read', 'session:write'])]
    private ?\DateTimeInterface $heureDebut = null;


    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(type: 'date')]
    #[groups(['session:read', 'session:write'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'AdminSession')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Admin $SessionAdmin = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'UsersSession')]
    private Collection $SessionUsers;

    #[ORM\Column(type: 'string', length: 255)]
    #[groups(['session:read', 'session:write'])]
    private ?string $responsible = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[groups(['session:read', 'session:write'])]
    private ?string $signature = null;

    #[ORM\OneToOne(mappedBy: 'ResultSession', cascade: ['persist', 'remove'])]
    private ?Result $SessionResultEnd = null;

    public function __construct()
    {
        $this->SessionUsers = new ArrayCollection();
        $this->heureFin = new \DateTime();
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

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): void
    {
        $this->signature = $signature;
    }

    public function getResponsible(): ?string
    {
        return $this->responsible;
    }

    public function setResponsible(?string $responsible): void
    {
        $this->responsible = $responsible;
    }

    public function getSessionResultEnd(): ?Result
    {
        return $this->SessionResultEnd;
    }

    public function setSessionResultEnd(?Result $SessionResultEnd): static
    {
        // unset the owning side of the relation if necessary
        if ($SessionResultEnd === null && $this->SessionResultEnd !== null) {
            $this->SessionResultEnd->setResultSession(null);
        }

        // set the owning side of the relation if necessary
        if ($SessionResultEnd !== null && $SessionResultEnd->getResultSession() !== $this) {
            $SessionResultEnd->setResultSession($this);
        }

        $this->SessionResultEnd = $SessionResultEnd;

        return $this;
    }
}
