<?php

namespace MyBudget\Domain\Entity\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Account implements UserInterface
{
    private UuidInterface $id;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable|null $updatedAt;

    private ?string $firstname;

    private ?string $lastname;

    private string $email;

    private array $roles;

    private string $oidcIdentifier;

    private UserGroup|null $userGroup;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable();
        $this->roles = [];
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
        return;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getOidcIdentifier(): string
    {
        return $this->oidcIdentifier;
    }

    public function getUserGroup(): ?UserGroup
    {
        return $this->userGroup;
    }

    public function defineGroup(UserGroup $group): void
    {
        $this->userGroup = $group;
    }
}
