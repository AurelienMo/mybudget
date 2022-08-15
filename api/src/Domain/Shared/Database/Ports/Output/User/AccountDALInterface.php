<?php

namespace MyBudget\Domain\Shared\Database\Ports\Output\User;

use MyBudget\Domain\Entity\User\Account;

interface AccountDALInterface
{
    public function findByEmail(string $email): ?Account;
}
