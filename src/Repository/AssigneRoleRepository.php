<?php

namespace App\Repository;

use App\Entity\AssigneRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssigneRole>
 *
 * @method AssigneRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssigneRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssigneRole[]    findAll()
 * @method AssigneRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssigneRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssigneRole::class);
    }

//    /**
//     * @return AssigneRole[] Returns an array of AssigneRole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssigneRole
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
