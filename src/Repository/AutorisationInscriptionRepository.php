<?php

namespace App\Repository;

use App\Entity\AutorisationInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AutorisationInscription>
 *
 * @method AutorisationInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutorisationInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutorisationInscription[]    findAll()
 * @method AutorisationInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutorisationInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutorisationInscription::class);
    }

    public function add(AutorisationInscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AutorisationInscription $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AutorisationInscription[] Returns an array of AutorisationInscription objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AutorisationInscription
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
