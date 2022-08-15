<?php

namespace MyBudget\Domain\Entity\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    private UuidInterface $id;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable|null $updatedAt;

    private ?string $firstname;

    private ?string $lastname;

    private string $email;

    private array $roles;

    private UserGroup|null $userGroup;

    private string $password;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable();
        $this->roles = ['ROLE_USER'];
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

    public function getUserGroup(): ?UserGroup
    {
        return $this->userGroup;
    }

    public function defineGroup(UserGroup $group): void
    {
        $this->userGroup = $group;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function createUser(string $firstname, string $lastname, string $email): Account
    {
        $self = new self();
        $self->firstname = $firstname;
        $self->lastname = $lastname;
        $self->email = $email;

        return $self;
    }

    public function definePassword(string $encodePassword): void
    {
        $this->password = $encodePassword;
    }
}
