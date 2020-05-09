<?php

namespace App\Repository;

use App\Entity\Marais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marais|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marais|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marais[]    findAll()
 * @method Marais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaraisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marais::class);
    }

    // /**
    //  * @return Marais[] Returns an array of Marais objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marais
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
