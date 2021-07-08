<?php

namespace App\Repository;

use App\Entity\Sitios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sitios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sitios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sitios[]    findAll()
 * @method Sitios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitiosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sitios::class);
    }

    // /**
    //  * @return Sitios[] Returns an array of Sitios objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sitios
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
