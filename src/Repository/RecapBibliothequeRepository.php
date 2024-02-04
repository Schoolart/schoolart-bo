<?php

namespace App\Repository;

use App\Entity\RecapBibliotheque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecapBibliotheque>
 *
 * @method RecapBibliotheque|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecapBibliotheque|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecapBibliotheque[]    findAll()
 * @method RecapBibliotheque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecapBibliothequeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecapBibliotheque::class);
    }

    public function save(RecapBibliotheque $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecapBibliotheque $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RecapBibliotheque[] Returns an array of RecapBibliotheque objects
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

//    public function findOneBySomeField($value): ?RecapBibliotheque
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
