<?php

namespace MyBudget\Domain\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MyBudget\Domain\User\UseCases\CreateGroup\DTO\CreateGroupRequest;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserGroup
{
    private UuidInterface $id;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable|null $updatedAt;

    private string $name;

    private string $code;

    private string $password;

    private Collection $members;

    private Account $owner;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable();
        $this->members = new ArrayCollection();
    }

    public static function createFromAPI(CreateGroupRequest $request, string $password, Account $currentUser): UserGroup
    {
        $userGroup = new self();
        $userGroup->name = $request->getName();
        $userGroup->code = $request->getCode();
        $userGroup->password = $password;
        $userGroup->owner = $currentUser;
        $userGroup->members->add($currentUser);

        return $userGroup;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getMembers(): ArrayCollection|Collection
    {
        return $this->members;
    }

    public function getOwner(): Account
    {
        return $this->owner;
    }

    public function addMember(Account $member): void
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->defineGroup($this);
        }
    }
}
