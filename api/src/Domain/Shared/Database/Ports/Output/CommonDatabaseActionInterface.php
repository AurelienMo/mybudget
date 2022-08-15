<?php

namespace MyBudget\Domain\Shared\Database\Ports\Output;

interface CommonDatabaseActionInterface
{
    public function save(object $entity, bool $needPersist = false): void;

    public function remove(object $entity): void;
}
