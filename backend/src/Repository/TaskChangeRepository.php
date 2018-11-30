<?php

namespace App\Repository;

use App\Doctrine\DBAL\Type\TaskChangeActionType;
use App\Entity\TaskChange;
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
     * @param \DateTime $start
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findTransferredFromWithTasks(\DateTime $start)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('t')
            ->andWhere('c.forDate = :start')
            ->andWhere('c.action = :action')
            ->setParameter('start', $start)
            ->setParameter('action', TaskChangeActionType::TRANSFER_FROM)
            ->leftJoin('c.task', 't')
            ->getQuery()
            ->getResult()
        ;
    }
}
