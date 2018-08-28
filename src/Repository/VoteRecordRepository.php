<?php

namespace App\Repository;

use App\Entity\VoteRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VoteRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoteRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoteRecord[]    findAll()
 * @method VoteRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRecordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VoteRecord::class);
    }

//    /**
//     * @return VoteRecord[] Returns an array of VoteRecord objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoteRecord
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
