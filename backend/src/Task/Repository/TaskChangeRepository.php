<?php

namespace Task\Repository;

use Task\Entity\TaskChange;
use User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TaskChange|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskChange|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskChange[]    findAll()
 * @method TaskChange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskChangeRepository extends ServiceEntityRepository
{
    /**
     * TaskChangeRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskChange::class);
    }

    /**
     * @param \DateTime $forDate
     * @param User      $user
     *
     * @return mixed
     */
    public function findByForDate(\DateTime $forDate, User $user)
    {
        return $this->createQueryBuilder('change')
            ->addSelect('task')
            ->andWhere('task.user = :user')
            ->andWhere('change.forDate = :forDate')
            ->leftJoin('change.task', 'task')
            ->setParameter('user', $user)
            ->setParameter('forDate', $forDate)
            ->getQuery()
            ->getResult()
        ;
    }
}
