<?php

namespace App\Repository;

use App\Entity\FicheIdentification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FicheIdentification>
 *
 * @method FicheIdentification|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheIdentification|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheIdentification[]    findAll()
 * @method FicheIdentification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheIdentificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheIdentification::class);
    }

    public function save(FicheIdentification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FicheIdentification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FicheIdentification[] Returns an array of FicheIdentification objects
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

//    public function findOneBySomeField($value): ?FicheIdentification
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
