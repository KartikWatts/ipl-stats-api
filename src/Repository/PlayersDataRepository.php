<?php

namespace App\Repository;

use App\Entity\PlayersData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayersData|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayersData|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayersData[]    findAll()
 * @method PlayersData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayersDataRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, PlayersData::class);
        $this->manager= $manager;
    }

    public function saveRecord(PlayersData $playersData){
        $this->manager->persist($playersData);
        $this->manager->flush();
    }

    public function getFinalRowId(){
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRowCount(){
        $q=$this->createQueryBuilder('q')
            ->getQuery();
        return count($q->getScalarResult());
    }

    public function findPlayersInRange($start, $count, $team_id){
            $q= $this->createQueryBuilder('q');
            if($team_id) {
                return $q->add('select', 'p')
                    ->add('from', 'App:PlayersData p')
                    ->add('where', 'p.team_id=' . $team_id)
                    ->getQuery()
                    ->setFirstResult($start)
                    ->setMaxResults($count)
                    ->getResult();
            }
             return $q->getQuery()
                    ->setFirstResult($start)
                    ->setMaxResults($count)
                    ->getResult();
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
