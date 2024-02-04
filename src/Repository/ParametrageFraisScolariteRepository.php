<?php

namespace App\Repository;

use App\Entity\ParametrageFraisScolarite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrageFraisScolarite>
 *
 * @method ParametrageFraisScolarite|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrageFraisScolarite|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrageFraisScolarite[]    findAll()
 * @method ParametrageFraisScolarite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrageFraisScolariteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrageFraisScolarite::class);
    }

    public function save(ParametrageFraisScolarite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParametrageFraisScolarite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    /**
//     * @return ParametrageFraisScolarite[] Returns an array of ParametrageFraisScolarite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParametrageFraisScolarite
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
