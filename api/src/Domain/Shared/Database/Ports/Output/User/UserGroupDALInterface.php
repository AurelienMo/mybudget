<?php

namespace MyBudget\Domain\Shared\Database\Ports\Output\User;

use MyBudget\Domain\Entity\User\UserGroup;

interface UserGroupDALInterface
{
    public function findByCode(string $code): ?UserGroup;
}
