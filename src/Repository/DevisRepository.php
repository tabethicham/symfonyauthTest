<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devis::class);
    }
    
    public function getLastId()
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = 'SELECT Max(id) as max FROM devis';
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();
    //echo $resultSet;
    // returns an array of arrays (i.e. a raw data set)
    return $resultSet->fetchAllAssociative()[0]['max'];


}
public function getLastIdByLastYear()
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "SELECT Max(id) as max FROM devis where devis.ref_devis like '2021%'";
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();
    //echo $resultSet;
    // returns an array of arrays (i.e. a raw data set)
    return $resultSet->fetchAllAssociative()[0]['max'];


}

/*
    public function getLastId()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT Max(id) FROM devis';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }*/
    // /**
    //  * @return Devis[] Returns an array of Devis objects
    //  */
    /*

     

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Devis
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
