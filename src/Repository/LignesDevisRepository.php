<?php

namespace App\Repository;

use App\Entity\LignesDevis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LignesDevis|null find($id, $lockMode = null, $lockVersion = null)
 * @method LignesDevis|null findOneBy(array $criteria, array $orderBy = null)
 * @method LignesDevis[]    findAll()
 * @method LignesDevis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LignesDevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LignesDevis::class);
    }
    public function findByDevisId($value){
        $query = $this->createQueryBuilder('a')
            ->where('a.devisId=:val')
            ->setParameter('val' , '%'.$value.'%')->getQuery();
 
        return $query->getResult();
    }
    

    // /**
    //  * @return LignesDevis[] Returns an array of LignesDevis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LignesDevis
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

   
}