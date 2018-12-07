<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param \DateTime $start
     * @param User      $user
     *
     * @return mixed
     */
    public function findByDate(\DateTime $start, User $user)
    {
        return $this->createQueryBuilder('task')
            ->addSelect('change')
            ->addSelect('transfer')
            ->andWhere('task.user = :user')
            ->andWhere('task.startDate <= :start')
            ->leftJoin('task.changes', 'change')
            ->leftJoin('task.transfers', 'transfer', Join::WITH, 'transfer.task = task')
            ->orderBy('task.id', 'desc')
            ->addOrderBy('transfer.id', 'asc')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @param User      $user
     *
     * @return mixed
     */
    public function findByDateRange(\DateTime $start, \DateTime $end, User $user)
    {
        return $this->createQueryBuilder('task')
            ->addSelect('change')
            ->addSelect('transfer')
            ->andWhere('task.user = :user')
            ->andWhere('task.startDate <= :start')
            ->leftJoin('task.changes', 'change')
            ->leftJoin('task.transfers', 'transfer', Join::WITH, 'transfer.task = task')
            ->orderBy('task.id', 'desc')
            ->addOrderBy('transfer.id', 'asc')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->getQuery()
            ->getResult()
        ;
    }
}
