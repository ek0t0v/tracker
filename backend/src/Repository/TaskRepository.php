<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     *
     * @return mixed
     */
    public function findByStartDate(\DateTime $start)
    {
        return $this->createQueryBuilder('t')
            ->addSelect('c')
            ->andWhere('t.startDate <= :start')
            ->setParameter('start', $start)
            ->leftJoin('t.changes', 'c')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     *
     * @return mixed
     */
    public function findByDateRange(\DateTime $start, \DateTime $end)
    {
        return $this->createQueryBuilder('t')
            ->getQuery()
            ->getResult()
        ;
    }
}
