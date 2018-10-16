<?php

namespace App\Repository;

use App\Entity\Postal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Postal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postal[]    findAll()
 * @method Postal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Postal::class);
    }

//    /**
//     * @return Postal[] Returns an array of Postal objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Postal
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
