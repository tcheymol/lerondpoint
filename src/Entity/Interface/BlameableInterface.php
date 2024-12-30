<?php

namespace App\Entity\Interface;

use App\Entity\User;

interface BlameableInterface
{
    public function getCreatedAt(): ?\DateTimeImmutable;

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void;

    public function getCreatedBy(): ?User;

    public function setCreatedBy(?User $createdBy): void;

    public function getUpdatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void;

    public function getUpdatedBy(): ?User;

    public function setUpdatedBy(?User $updatedBy): void;

    public function getDeletedAt(): ?\DateTimeImmutable;

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): void;

    public function getDeletedBy(): ?User;

    public function setDeletedBy(?User $deletedBy): void;

    public function isDisabled(): bool;

    public function setDisabled(bool $disabled): void;

    public function getDisabledBy(): ?User;

    public function setDisabledBy(?User $disabledBy): void;

    public function isValidated(): ?bool;

    public function setValidated(bool $validated): void;

    public function getValidatedBy(): ?User;

    public function setValidatedBy(?User $validatedBy): void;

    public function isRejected(): ?bool;

    public function setRejected(bool $rejected): void;

    public function getRejectedBy(): ?User;

    public function setRejectedBy(?User $rejectedBy): void;
}
