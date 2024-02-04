<?php

namespace App\Repository;

use App\Entity\CategorieFraisScolarite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieFraisScolarite>
 *
 * @method CategorieFraisScolarite|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieFraisScolarite|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieFraisScolarite[]    findAll()
 * @method CategorieFraisScolarite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFraisScolariteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieFraisScolarite::class);
    }

    public function save(CategorieFraisScolarite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieFraisScolarite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CategorieFraisScolarite[] Returns an array of CategorieFraisScolarite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategorieFraisScolarite
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
