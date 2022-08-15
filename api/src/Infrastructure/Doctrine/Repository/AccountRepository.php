<?php

namespace MyBudget\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyBudget\Domain\Entity\User\Account;
use MyBudget\Domain\Shared\Database\Ports\Output\User\AccountDALInterface;

class AccountRepository extends ServiceEntityRepository implements AccountDALInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    public function findByEmail(string $email): ?Account
    {
        return $this->createQueryBuilder('a')
            ->where('a.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
