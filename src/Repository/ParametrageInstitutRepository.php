<?php

namespace App\Repository;

use App\Entity\ParametrageInstitut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrageInstitut>
 *
 * @method ParametrageInstitut|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrageInstitut|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrageInstitut[]    findAll()
 * @method ParametrageInstitut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrageInstitutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrageInstitut::class);
    }

    public function add(ParametrageInstitut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParametrageInstitut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ParametrageInstitut[] Returns an array of ParametrageInstitut objects
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

//    public function findOneBySomeField($value): ?ParametrageInstitut
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
