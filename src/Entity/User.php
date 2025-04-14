<?php

namespace App\Entity;

use App\Entity\Interface\BlameableInterface;
use App\Entity\Trait\BlameableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Stringable, BlameableInterface
{
    use BlameableTrait;

    public const array ROLES = [
        'ROLE_USER' => 'ROLE_USER',
        'ROLE_VALIDATED_USER' => 'ROLE_VALIDATED_USER',
        'ROLE_MODERATOR' => 'ROLE_MODERATOR',
        'ROLE_ADMIN' => 'ROLE_ADMIN',
        'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @var string[] */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    private ?string $plainPassword = null;

    #[\Override]
    public function __toString(): string
    {
        return (string) $this->email;
    }

    /** @var Collection<int, Collective> */
    #[ORM\OneToMany(targetEntity: Collective::class, mappedBy: 'owner')]
    private Collection $collectivesOwned;

    #[ORM\Column(nullable: true)]
    private ?bool $validatedEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    /** @var Collection<int, Invitation> */
    #[ORM\OneToMany(targetEntity: Invitation::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $invitations;

    /** @var Collection<int, Track> */
    #[ORM\OneToMany(targetEntity: Track::class, mappedBy: 'createdBy')]
    private Collection $tracks;

    /**
     * @var Collection<int, Invitation>
     */
    #[ORM\OneToMany(targetEntity: Invitation::class, mappedBy: 'invitedBy', orphanRemoval: true)]
    private Collection $invitationsSent;

    /**
     * @var Collection<int, Collective>
     */
    #[ORM\ManyToMany(targetEntity: Collective::class, inversedBy: 'members')]
    private Collection $collectives;

    #[ORM\Column]
    private ?bool $hasAcceptedTerms = null;

    public function __construct(
        #[ORM\Column(length: 180)]
        private ?string $email = null,
    ) {
        $this->collectivesOwned = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->tracks = new ArrayCollection();
        $this->invitationsSent = new ArrayCollection();
        $this->collectives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    #[\Override]
    public function getUserIdentifier(): string
    {
        return (string) $this->email ?: 'Anonymous user';
    }

    /**
     * @see UserInterface
     *
     * @return string[]
     */
    #[\Override]
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): static
    {
        if (!$this->hasRole($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function hasRole(string $string): bool
    {
        return in_array($string, $this->roles, true);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    #[\Override]
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    #[\Override]
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /** @return Collection<int, Collective> */
    public function getCollectivesOwned(): Collection
    {
        return $this->collectivesOwned;
    }

    public function addCollectiveOwned(Collective $collective): static
    {
        if (!$this->collectivesOwned->contains($collective)) {
            $this->collectivesOwned->add($collective);
            $collective->setOwner($this);
        }

        return $this;
    }

    public function removeCollectiveOwned(Collective $collective): static
    {
        if ($this->collectivesOwned->removeElement($collective)) {
            // set the owning side to null (unless already changed)
            if ($collective->getOwner() === $this) {
                $collective->setOwner(null);
            }
        }

        return $this;
    }

    public function hasCollective(): bool
    {
        return $this->collectives->count() > 0;
    }

    public function getFirstCollective(): ?Collective
    {
        return $this->collectives->first() ?: null;
    }

    public function isValidatedEmail(): ?bool
    {
        return $this->validatedEmail;
    }

    public function setValidatedEmail(?bool $validatedEmail): static
    {
        $this->validatedEmail = $validatedEmail;

        return $this;
    }

    public function validateEmail(): static
    {
        $this->validatedEmail = true;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /** @return Collection<int, Invitation> */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): static
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setUser($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): static
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getUser() === $this) {
                $invitation->setUser(null);
            }
        }

        return $this;
    }

    /** @return Collection<int, Track> */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): static
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks->add($track);
            $track->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): static
    {
        if ($this->tracks->removeElement($track)) {
            if ($track->getCreatedBy() === $this) {
                $track->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitationsSent(): Collection
    {
        return $this->invitationsSent;
    }

    public function addInvitationsSent(Invitation $invitationsSent): static
    {
        if (!$this->invitationsSent->contains($invitationsSent)) {
            $this->invitationsSent->add($invitationsSent);
            $invitationsSent->setInvitedBy($this);
        }

        return $this;
    }

    public function removeInvitationsSent(Invitation $invitationsSent): static
    {
        if ($this->invitationsSent->removeElement($invitationsSent)) {
            // set the owning side to null (unless already changed)
            if ($invitationsSent->getInvitedBy() === $this) {
                $invitationsSent->setInvitedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Collective>
     */
    public function getCollectives(): Collection
    {
        return $this->collectives;
    }

    public function addCollective(Collective $collective): static
    {
        if (!$this->collectives->contains($collective)) {
            $this->collectives->add($collective);
        }

        return $this;
    }

    public function removeCollective(Collective $collective): static
    {
        $this->collectives->removeElement($collective);

        return $this;
    }

    public function hasAcceptedTerms(): ?bool
    {
        return $this->hasAcceptedTerms;
    }

    public function setHasAcceptedTerms(bool $hasAcceptedTerms): static
    {
        $this->hasAcceptedTerms = $hasAcceptedTerms;

        return $this;
    }
}
