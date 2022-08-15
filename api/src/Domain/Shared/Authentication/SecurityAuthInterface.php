<?php

namespace MyBudget\Domain\Shared\Authentication;

use MyBudget\Domain\Entity\User\Account;

interface SecurityAuthInterface
{
    public function getCurrentUser(): Account;

    public function encodePassword(string $password): string;

    public function hashPassword(Account $user, string $password): string;

    public function logUser(Account $user): array;
}
