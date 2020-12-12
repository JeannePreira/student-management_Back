<?php

namespace App\Repository;

use App\Entity\ApprenantLivrableAttendu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApprenantLivrableAttendu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApprenantLivrableAttendu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApprenantLivrableAttendu[]    findAll()
 * @method ApprenantLivrableAttendu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApprenantLivrableAttenduRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApprenantLivrableAttendu::class);
    }

    // /**
    //  * @return ApprenantLivrableAttendu[] Returns an array of ApprenantLivrableAttendu objects
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
    public function findOneBySomeField($value): ?ApprenantLivrableAttendu
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
