<?php

namespace App\Repository;

use App\Entity\Etudiant;
use App\Entity\Passage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Passage>
 *
 * @method Passage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passage[]    findAll()
 * @method Passage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passage::class);
    }

    public function save(Passage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Passage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Etudiant[] Returns an array of Passage objects
     */
    public function findByEtudiantSession2($periode,$classe): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->LeftJoin('p.periode', 'pe')
            ->addSelect('pe')
            ->LeftJoin('p.classe', 'c')
            ->addSelect('c')
            ->andWhere('pe = :periode')
            ->andWhere('c = :classe')
            ->select('p.etudiant')
            ->setParameter('periode', $periode)
            ->setParameter('classe', $classe)
            ->orderBy('p.id', 'desc')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Passage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
