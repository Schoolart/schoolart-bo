<?php

namespace App\Repository;

use App\Entity\InfoSupplementaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoSupplementaire>
 *
 * @method InfoSupplementaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSupplementaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSupplementaire[]    findAll()
 * @method InfoSupplementaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSupplementaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoSupplementaire::class);
    }

    public function save(InfoSupplementaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InfoSupplementaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InfoSupplementaire[] Returns an array of InfoSupplementaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InfoSupplementaire
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
