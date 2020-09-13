<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\UserProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProduit[]    findAll()
 * @method UserProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProduit::class);
    }



     /**
      * @return int Returns a number et surtout me fais pas chier
      * @param $user User
      * @param $product Produit
      */
    public function hasProduct($user,$product)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->andWhere('u.produit_id = :pId')
            ->andWhere('u.user_id = :uId')
            ->setParameter('uId', $user->getId())
            ->setParameter('pId', $product->getId())
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?UserProduit
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
