<?php

namespace App\Repository;

use App\Entity\EstimationRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EstimationRole>
 *
 * @method EstimationRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstimationRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstimationRole[]    findAll()
 * @method EstimationRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimationRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstimationRole::class);
    }

    public function save(EstimationRole $estimationRole): void
    {
        $this->_em->persist($estimationRole);
        $this->_em->flush();
    }

//    /**
//     * @return EstimationRole[] Returns an array of EstimationRole objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EstimationRole
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
