<?php

namespace App\Repository;

use App\Entity\AdminUse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminUse|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminUse|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminUse[]    findAll()
 * @method AdminUse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminUseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminUse::class);
    }

    // /**
    //  * @return AdminUse[] Returns an array of AdminUse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminUse
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
