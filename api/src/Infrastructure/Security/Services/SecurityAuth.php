<?php

namespace MyBudget\Infrastructure\Security\Services;

use MyBudget\Domain\Entity\User\Account;
use MyBudget\Domain\Shared\Authentication\SecurityAuthInterface;
use Symfony\Component\Security\Core\Security;

class SecurityAuth implements SecurityAuthInterface
{
    public function __construct(private Security $security) {}

    public function getCurrentUser(): Account
    {
        return $this->security->getUser();
    }

    public function encodePassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
