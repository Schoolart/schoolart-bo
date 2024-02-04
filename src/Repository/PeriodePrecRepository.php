<?php

namespace App\Repository;

use App\Entity\PeriodePrec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PeriodePrec>
 *
 * @method PeriodePrec|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodePrec|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodePrec[]    findAll()
 * @method PeriodePrec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodePrecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodePrec::class);
    }

    public function save(PeriodePrec $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PeriodePrec $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PeriodePrec[] Returns an array of PeriodePrec objects
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

//    public function findOneBySomeField($value): ?PeriodePrec
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
