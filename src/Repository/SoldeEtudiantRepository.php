<?php

namespace App\Repository;

use App\Entity\SoldeEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SoldeEtudiant>
 *
 * @method SoldeEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method SoldeEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method SoldeEtudiant[]    findAll()
 * @method SoldeEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoldeEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SoldeEtudiant::class);
    }

    public function save(SoldeEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SoldeEtudiant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SoldeEtudiant[] Returns an array of SoldeEtudiant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SoldeEtudiant
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
