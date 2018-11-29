<?php

namespace App\Repository;

use App\Entity\TaskTiming;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TaskTiming|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskTiming|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskTiming[]    findAll()
 * @method TaskTiming[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskTimingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskTiming::class);
    }

//    /**
//     * @return TaskTiming[] Returns an array of TaskTiming objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskTiming
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
