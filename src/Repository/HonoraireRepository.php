<?php

namespace App\Repository;

use App\Entity\Honoraire;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Honoraire>
 *
 * @method Honoraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Honoraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Honoraire[]    findAll()
 * @method Honoraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HonoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Honoraire::class);
    }

    public function save(Honoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Honoraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return Honoraire[]
     */
    public function findByDate($annee,$institut,$prof,$dateDebut,$dateFin,$cycle,$matiere)
    {
        return
            $this->createQueryBuilder('param')
                ->select('param')
                ->LeftJoin('param.professeur', 'prf')
                ->andWhere('prf = :prof')
                ->LeftJoin('param.anneeAcademic', 'an')
                ->andWhere('an = :annee')
                ->LeftJoin('param.institut', 'inst')
                ->andWhere('inst = :institut')
                ->LeftJoin('param.matiere', 'mat')
                ->andWhere('mat = :matiere')
                ->andWhere('param.date <= :dateFin')
                ->andWhere('param.date >= :dateDebut')
                ->andWhere('param.cycle = :cycle')
                ->setParameter('cycle',$cycle)
                ->setParameter('matiere',$matiere)
                ->setParameter('dateFin',new DateTime($dateFin))
                ->setParameter('dateDebut',$dateDebut)
                ->setParameter('annee',$annee)
                ->setParameter('institut',$institut)
                ->setParameter('prof',$prof)
                ->orderBy('param.date', 'ASC')
                ->getQuery()
                ->getResult();
    }

//    /**
//     * @return Honoraire[] Returns an array of Honoraire objects
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

//    public function findOneBySomeField($value): ?Honoraire
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
