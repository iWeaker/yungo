<?php

namespace App\Repository;

use App\Entity\Inventario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inventario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventario[]    findAll()
 * @method Inventario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventario::class);
    }

     /**
      * @return Inventario[]
     */

    public function checkDuplicatedMac($id, $mac )
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.mac_inventory = :mac  AND i.id != :id')
            ->setParameter('mac', $mac)
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Inventario
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */




}
