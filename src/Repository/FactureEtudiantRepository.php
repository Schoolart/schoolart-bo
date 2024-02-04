<?php

namespace App\Repository;

use App\Entity\FactureEtudiant;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FactureEtudiant>
 *
 * @method FactureEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactureEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactureEtudiant[]    findAll()
 * @method FactureEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactureEtudiant::class);
    }

    public function save(FactureEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FactureEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return FactureEtudiant[] Returns an array of FactureEtudiant objects
     */
    public function findByDate($annee,$classe,$etudiant,$solder,$date)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.etudiant', 'et')
                ->andWhere('et = :etudiant')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->LeftJoin('param.parametrageFraisScolarite', 'fr')
                ->Andwhere('fr.date <= :date')
                ->LeftJoin('param.classe', 'cl')
                ->andWhere('cl = :classe')
                ->andWhere('param.solder = :solder')
                ->setParameter('date',$date)
                ->setParameter('annee',$annee)
                ->setParameter('classe',$classe)
                ->setParameter('solder',$solder)
                ->setParameter('etudiant',$etudiant)
                ->orderBy('fr.date', 'ASC')
                ->getQuery()
                ->getResult();
    }
    /**
     * @return FactureEtudiant[] Returns an array of FactureEtudiant objects
     */
    public function findByAnneAndByDate($annee,$solder,DateTime $date)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->LeftJoin('param.parametrageFraisScolarite', 'fr')
                ->Andwhere('fr.date <= :dateBefore')
                ->Andwhere('fr.date >= :dateAfter')
                ->andWhere('param.solder = :solder')
                ->setParameter('dateBefore',$date->setTime(23,59))
                ->setParameter('dateAfter',$date->setTime(0,0))
                ->setParameter('annee',$annee)
                ->setParameter('solder',$solder)
                ->orderBy('fr.date', 'ASC')
                ->getQuery()
                ->getResult();
    }
    /**
     * @return FactureEtudiant[] Returns an array of FactureEtudiant objects
     */
    public function findBySolder($annee,$classe,$etudiant,$solder)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.etudiant', 'et')
                ->andWhere('et = :etudiant')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->LeftJoin('param.parametrageFraisScolarite', 'fr')
                ->LeftJoin('param.classe', 'cl')
                ->andWhere('cl = :classe')
                ->andWhere('param.solder = :solder')
                ->setParameter('annee',$annee)
                ->setParameter('classe',$classe)
                ->setParameter('solder',$solder)
                ->setParameter('etudiant',$etudiant)
                ->orderBy('fr.date', 'ASC')
                ->getQuery()
                ->getResult();
    }
//    /**
//     * @return FactureEtudiant[] Returns an array of FactureEtudiant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FactureEtudiant
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
