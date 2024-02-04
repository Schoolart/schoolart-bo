<?php

namespace App\Repository;

use App\Entity\RecapAnnee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecapAnnee>
 *
 * @method RecapAnnee|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecapAnnee|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecapAnnee[]    findAll()
 * @method RecapAnnee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecapAnneeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecapAnnee::class);
    }

    public function save(RecapAnnee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecapAnnee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RecapAnnee[] Returns an array of RecapAnnee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RecapAnnee
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
