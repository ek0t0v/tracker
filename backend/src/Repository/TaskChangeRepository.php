<?php

namespace App\Repository;

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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskChange::class);
    }

//    /**
//     * @return TaskChange[] Returns an array of TaskChange objects
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
    public function findOneBySomeField($value): ?TaskChange
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
