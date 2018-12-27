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
     * @param User $user
     *
     * @return mixed
     */
    public function findAllByUser(User $user)
    {
        return $this->createQueryBuilder('task')
            ->addSelect('transfer')
            ->addSelect('change')
            ->andWhere('task.user = :user')
            ->leftJoin('task.changes', 'change')
            ->leftJoin('task.transfers', 'transfer')
            ->orderBy('task.id', 'desc')
            ->addOrderBy('transfer.id', 'asc')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param \DateTime $start
     * @param User      $user
     *
     * @return mixed
     */
    public function findByStartDate(\DateTime $start, User $user)
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
     * @param User $user
     *
     * @return mixed
     */
    public function findOverdueTasks(User $user)
    {
        return $this->createQueryBuilder('task')
            ->addSelect('change')
            ->addSelect('transfer')
            ->andWhere('task.user = :user')
            ->andWhere('task.startDate < CURRENT_TIMESTAMP()')
            ->leftJoin('task.changes', 'change', Join::WITH, 'change.forDate < CURRENT_TIMESTAMP()')
            ->leftJoin('task.transfers', 'transfer', Join::WITH, 'transfer.task = task')
            ->orderBy('task.id', 'desc')
            ->addOrderBy('transfer.id', 'asc')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @todo del
     *
     * @param User $user
     *
     * @return \DateTime|null
     */
    public function findOldestStartDate(User $user)
    {
        $dates = $this->createQueryBuilder('task')
            ->select('MIN(task.startDate) AS startDate, MIN(transfer.transferTo) AS transferTo')
            ->andWhere('task.user = :user')
            ->leftJoin('task.transfers', 'transfer')
            ->groupBy('task.id')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;

        $oldestDate = null;

        array_map(function ($item) use (&$oldestDate) {
            $startDate = new \DateTime($item['startDate']);
            $transferTo = new \DateTime($item['transferTo']);

            $date = $startDate <= $transferTo ? $startDate : $transferTo;

            if (is_null($oldestDate) || $oldestDate > $date) {
                $oldestDate = $date;
            }
        }, $dates);

        return $oldestDate;
    }
}
