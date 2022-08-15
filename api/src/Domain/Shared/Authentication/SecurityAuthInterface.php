<?php

namespace MyBudget\Domain\Shared\Authentication;

use MyBudget\Domain\Entity\User\Account;

interface SecurityAuthInterface
{
    public function getCurrentUser(): Account;

    public function encodePassword(string $password): string;
}
