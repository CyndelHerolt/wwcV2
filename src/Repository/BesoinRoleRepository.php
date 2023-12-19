<?php

namespace App\Repository;

use App\Entity\BesoinRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BesoinRole>
 *
 * @method BesoinRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method BesoinRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method BesoinRole[]    findAll()
 * @method BesoinRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BesoinRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BesoinRole::class);
    }

//    /**
//     * @return BesoinRole[] Returns an array of BesoinRole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BesoinRole
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
