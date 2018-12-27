<?php

namespace App\Repository;

use App\Entity\UserSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSettings[]    findAll()
 * @method UserSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSettingsRepository extends ServiceEntityRepository
{
    /**
     * UserSettingsRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSettings::class);
    }
}
