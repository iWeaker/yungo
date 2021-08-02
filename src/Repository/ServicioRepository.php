<?php

namespace App\Repository;

use App\Entity\Servicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Servicio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Servicio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Servicio[]    findAll()
 * @method Servicio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Servicio::class);
    }

    // /**
    //  * @return Servicio[] Returns an array of Servicio objects
    //  */
    
    public function findMultiServices($value)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.fkAddress', 'a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Servicio[] Returns an array of Servicio objects
    //  */
    public function findAllServicesCliente($value)
    {

        return $this->createQueryBuilder('s')
            ->leftJoin('s.fkAddress', 'a')
            ->leftJoin('a.clientes', 'c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    /*
     *
     * /*
     *$conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM servicio s
                LEFT JOIN direccion d ON s.fk_address_id = d.id
                LEFT JOIN clientes c ON d.clientes_id = c.id WHERE c.id = :value;
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['value' => $value]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
     */

    /*
    public function findOneBySomeField($value): ?Servicio
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
