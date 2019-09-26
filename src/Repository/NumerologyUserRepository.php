<?php

namespace App\Repository;

use App\Entity\NumerologyUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NumerologyUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method NumerologyUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method NumerologyUser[]    findAll()
 * @method NumerologyUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerologyUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NumerologyUser::class);
    }

    // /**
    //  * @return NumerologyUser[] Returns an array of NumerologyUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NumerologyUser
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
