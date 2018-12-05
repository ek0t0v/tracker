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
    /**
     * TaskChangeRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TaskChange::class);
    }
}
