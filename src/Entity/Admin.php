<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ApiResource]
class Admin implements \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $signature = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'SessionAdmin')]
    private Collection $AdminSession;

    public function __construct()
    {
        $this->AdminSession = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getAdminSession(): Collection
    {
        return $this->AdminSession;
    }

    public function addAdminSession(Session $adminSession): static
    {
        if (!$this->AdminSession->contains($adminSession)) {
            $this->AdminSession->add($adminSession);
            $adminSession->setSessionAdmin($this);
        }

        return $this;
    }

    public function removeAdminSession(Session $adminSession): static
    {
        if ($this->AdminSession->removeElement($adminSession)) {
            // set the owning side to null (unless already changed)
            if ($adminSession->getSessionAdmin() === $this) {
                $adminSession->setSessionAdmin(null);
            }
        }

        return $this;
    }

}
