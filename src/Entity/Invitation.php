<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvitationRepository::class)]
class Invitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unregisteredEmail = null;

    public function __construct(
        #[ORM\ManyToOne(inversedBy: 'invitations')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Collective $collective = null,
        #[ORM\ManyToOne(inversedBy: 'invitations')]
        #[ORM\JoinColumn(nullable: true)]
        private ?User $user = null,
        #[ORM\ManyToOne(inversedBy: 'invitationsSent')]
        #[ORM\JoinColumn(nullable: false)]
        private ?User $invitedBy = null,
        #[ORM\Column(type: Types::DATE_MUTABLE)]
        private ?\DateTimeInterface $date = new \DateTime(),
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollective(): ?Collective
    {
        return $this->collective;
    }

    public function setCollective(?Collective $collective): static
    {
        $this->collective = $collective;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getInvitedBy(): ?User
    {
        return $this->invitedBy;
    }

    public function setInvitedBy(?User $invitedBy): static
    {
        $this->invitedBy = $invitedBy;

        return $this;
    }

    public function getUnregisteredEmail(): ?string
    {
        return $this->unregisteredEmail;
    }

    public function setUnregisteredEmail(?string $unregisteredEmail): static
    {
        $this->unregisteredEmail = $unregisteredEmail;

        return $this;
    }

    public function isUnregistered(): bool
    {
        return null !== $this->unregisteredEmail;
    }
}
