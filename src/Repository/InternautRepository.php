<?php

namespace App\Repository;

use App\Entity\Internaut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Internaut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Internaut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Internaut[]    findAll()
 * @method Internaut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternautRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Internaut::class);
    }

//    /**
//     * @return Internaut[] Returns an array of Internaut objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Internaut
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
