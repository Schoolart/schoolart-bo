<?php

namespace App\Repository;

use App\Entity\ParametrageFraisScolariteEtab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrageFraisScolariteEtab>
 *
 * @method ParametrageFraisScolariteEtab|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrageFraisScolariteEtab|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrageFraisScolariteEtab[]    findAll()
 * @method ParametrageFraisScolariteEtab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrageFraisScolariteEtabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrageFraisScolariteEtab::class);
    }

    public function save(ParametrageFraisScolariteEtab $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParametrageFraisScolariteEtab $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    //     * @return ParametrageFraisScolariteEtab[] Returns an array of ParametrageFraisScolariteEtab objects
    //     */
    public function findByDate($institut,$annee)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.institut', 'i')
                ->andWhere('i = :institut')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->Andwhere('param.date <= :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->setParameter('annee',$annee)
                ->setParameter('institut',$institut)
                ->orderBy('param.date', 'DESC')
                ->getQuery()
                ->getResult();
    }
//    /**
//     * @return ParametrageFraisScolariteEtab[] Returns an array of ParametrageFraisScolariteEtab objects
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

//    public function findOneBySomeField($value): ?ParametrageFraisScolariteEtab
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
