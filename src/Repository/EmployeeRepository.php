<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findByTermStrict(string $term) {

        $queryBuilder = $this->createQueryBuilder('e');
        // SELECT * FROM employee e

        $queryBuilder->where('e.name = :term');
        // SELECT * FROM employee e WHERE e.name = :term

        $queryBuilder->orWhere('e.email = :term');
        // SELECT * FROM employee e WHERE e.name = :term OR e.email = :term;

        $queryBuilder->orWhere('e.city = :term');
        // SELECT * FROM employee e WHERE e.name = :term OR e.email = :term OR e.city = :term;

        $queryBuilder->setParameter('term', $term);
        $queryBuilder->orderBy('e.id', 'ASC');

        // Si $term = 'hola
        // SELECT * FROM employee e WHERE e.name = 'hola' OR e.email = 'hola' OR e.city = 'hola' ORDER BY e.id ASC;

        $query = $queryBuilder->getQuery();

        return $query-> getResult();
    }

    public function findByTerm(string $term)
    {
        $queryBuilder = $this->createQueryBuilder('e');
    
        $queryBuilder->where(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.name' , ':term'),
                $queryBuilder->expr()->like('e.email' , ':term'),
                $queryBuilder->expr()->like('e.city' , ':term')
            )
        )
        ->setParameter('term', '%'.$term.'%')
        ->orderBy('e.id', 'ASC');
    
        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
