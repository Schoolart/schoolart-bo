<?php

namespace App\Repository;

use App\Entity\ParametrageFraisScolariteEtud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrageFraisScolariteEtud>
 *
 * @method ParametrageFraisScolariteEtud|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrageFraisScolariteEtud|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrageFraisScolariteEtud[]    findAll()
 * @method ParametrageFraisScolariteEtud[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrageFraisScolariteEtudRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrageFraisScolariteEtud::class);
    }

    public function save(ParametrageFraisScolariteEtud $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParametrageFraisScolariteEtud $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    //     * @return ParametrageFraisScolariteEtud[] Returns an array of ParametrageFraisScolariteEtud objects
    //     */
    public function findByDate($institut,$annee,$etudiant,$classe)
    {
        return
            $this->createQueryBuilder('param')
            ->select('param')
                ->LeftJoin('param.etudiant', 'e')
                ->andWhere('e = :etudiant')
                ->LeftJoin('param.classe', 'c')
                ->andWhere('c = :classe')
                ->LeftJoin('param.institut', 'i')
                ->andWhere('i = :institut')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
            ->Andwhere('param.date <= :datecourant')
            ->setParameter('datecourant', new \Datetime())
            ->setParameter('classe',$classe)
            ->setParameter('etudiant',$etudiant)
            ->setParameter('annee',$annee)
            ->setParameter('institut',$institut)
            ->orderBy('param.date', 'DESC')
                ->getQuery()
            ->getResult();
    }
    public function findByDateToAjour($institut,$annee,$etudiant)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.etudiant', 'e')
                ->andWhere('e = :etudiant')
                ->LeftJoin('param.institut', 'i')
                ->andWhere('i = :institut')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->Andwhere('param.date <= :datecourant')
                ->setParameter('datecourant', new \Datetime())
                ->setParameter('etudiant',$etudiant)
                ->setParameter('annee',$annee)
                ->setParameter('institut',$institut)
                ->orderBy('param.date', 'DESC')
                ->getQuery()
                ->getResult();
    }
//    /**
//     * @return ParametrageFraisScolariteEtud[] Returns an array of ParametrageFraisScolariteEtud objects
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

//    public function findOneBySomeField($value): ?ParametrageFraisScolariteEtud
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
