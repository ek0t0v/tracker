<?php

namespace App\Repository;

use App\Entity\TaskTransfer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TaskTransfer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskTransfer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskTransfer[]    findAll()
 * @method TaskTransfer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskTransferRepository extends ServiceEntityRepository
{
    /**
     * TaskTransferRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskTransfer::class);
    }

    /**
     * @param \DateTime $start
     * @param User      $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findTransferredTasksAfterDate(\DateTime $start, User $user)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('t')
            ->andWhere('c.transferTo >= :start')
            ->leftJoin('c.task', 't', Join::WITH, 't.user = :user')
            ->setParameter('start', $start)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
}
