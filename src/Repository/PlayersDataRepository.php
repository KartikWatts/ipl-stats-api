<?php

namespace App\Repository;

use App\Entity\PlayersData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayersData|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayersData|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayersData[]    findAll()
 * @method PlayersData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayersDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayersData::class);
    }

    // /**
    //  * @return PlayersData[] Returns an array of PlayersData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayersData
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
