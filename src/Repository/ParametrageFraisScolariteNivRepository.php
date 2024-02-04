<?php

namespace App\Repository;

use App\Entity\ParametrageFraisScolariteNiv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrageFraisScolariteNiv>
 *
 * @method ParametrageFraisScolariteNiv|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrageFraisScolariteNiv|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrageFraisScolariteNiv[]    findAll()
 * @method ParametrageFraisScolariteNiv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrageFraisScolariteNivRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrageFraisScolariteNiv::class);
    }

    public function save(ParametrageFraisScolariteNiv $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParametrageFraisScolariteNiv $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    //     * @return ParametrageFraisScolariteNiv[] Returns an array of ParametrageFraisScolariteNiv objects
    //     */
    public function findByDate($institut,$annee,$niveau)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.niveau', 'e')
                ->andWhere('e = :niveau')
                ->LeftJoin('param.institut', 'i')
                ->andWhere('i = :institut')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->Andwhere('param.date <= :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->setParameter('niveau',$niveau)
                ->setParameter('annee',$annee)
                ->setParameter('institut',$institut)
                ->orderBy('param.date', 'DESC')
                ->getQuery()
                ->getResult();
    }
    public function findByDateToAjour($institut,$annee)
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
//     * @return ParametrageFraisScolariteNiv[] Returns an array of ParametrageFraisScolariteNiv objects
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

//    public function findOneBySomeField($value): ?ParametrageFraisScolariteNiv
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
