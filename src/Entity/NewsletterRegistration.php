<?php

namespace App\Entity;

use App\Repository\NewsletterRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Email;

#[ORM\Entity(repositoryClass: NewsletterRegistrationRepository::class)]
#[UniqueEntity('email')]
class NewsletterRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $isConfirmed = false;

    #[ORM\Column]
    private bool $isUnsubscribed = false;

    public function __construct(
        #[ORM\Column(length: 255, unique: true)]
        #[Email]
        private ?string $email = null,
    ) {
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

    public function isConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): static
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function isUnsubscribed(): ?bool
    {
        return $this->isUnsubscribed;
    }

    public function setIsUnsubscribed(bool $isUnsubscribed): static
    {
        $this->isUnsubscribed = $isUnsubscribed;

        return $this;
    }
}
