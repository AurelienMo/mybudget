<?php

namespace MyBudget\Infrastructure\Doctrine\Common;

use Doctrine\ORM\EntityManagerInterface;
use MyBudget\Domain\Shared\Database\Ports\Output\CommonDatabaseActionInterface;

class DatabaseAction implements CommonDatabaseActionInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function save(object $entity, bool $needPersist = false): void
    {
        if ($needPersist) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
