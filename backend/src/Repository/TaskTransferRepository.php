<?php

namespace App\Repository;

use App\Entity\TaskTransfer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
