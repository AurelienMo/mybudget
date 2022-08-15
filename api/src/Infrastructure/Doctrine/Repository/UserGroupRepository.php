<?php

namespace MyBudget\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use MyBudget\Domain\Entity\User\UserGroup;
use MyBudget\Domain\Shared\Database\Ports\Output\User\UserGroupDALInterface;

class UserGroupRepository extends ServiceEntityRepository implements UserGroupDALInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroup::class);
    }

    public function findByCode(string $code): ?UserGroup
    {
        return $this->createQueryBuilder('ug')
            ->where('ug.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
