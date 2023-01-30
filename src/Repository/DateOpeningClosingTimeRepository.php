<?php

namespace App\Repository;

use App\Entity\DateOpeningClosingTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DateOpeningClosingTime>
 *
 * @method DateOpeningClosingTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateOpeningClosingTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateOpeningClosingTime[]    findAll()
 * @method DateOpeningClosingTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateOpeningClosingTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateOpeningClosingTime::class);
    }

    public function save(DateOpeningClosingTime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DateOpeningClosingTime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DateOpeningClosingTime[] Returns an array of DateOpeningClosingTime objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DateOpeningClosingTime
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
