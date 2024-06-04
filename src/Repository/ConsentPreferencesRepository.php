<?php

namespace App\Repository;

use App\Entity\ConsentPreferences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsentPreferences>
 *
 * @method ConsentPreferences|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsentPreferences|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsentPreferences[]    findAll()
 * @method ConsentPreferences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsentPreferencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsentPreferences::class);
    }

    //    /**
    //     * @return ConsentPreferences[] Returns an array of ConsentPreferences objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ConsentPreferences
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
