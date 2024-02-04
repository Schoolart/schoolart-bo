<?php

namespace App\Repository;

use App\Entity\HonoraireRecap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HonoraireRecap>
 *
 * @method HonoraireRecap|null find($id, $lockMode = null, $lockVersion = null)
 * @method HonoraireRecap|null findOneBy(array $criteria, array $orderBy = null)
 * @method HonoraireRecap[]    findAll()
 * @method HonoraireRecap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HonoraireRecapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HonoraireRecap::class);
    }

    public function save(HonoraireRecap $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HonoraireRecap $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HonoraireRecap[] Returns an array of HonoraireRecap objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HonoraireRecap
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
