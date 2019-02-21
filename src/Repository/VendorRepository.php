<?php

namespace App\Repository;

use App\Entity\Vendor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vendor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vendor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vendor[]    findAll()
 * @method Vendor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vendor::class);
    }

    /**
     * @param $value
     * @return Vendor[] Returns an array of Vendor objects
     */
    public function findLast($value)
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.id', 'DESC')
            ->andWhere('v.is_visible = :val')
            ->setParameter('val', 1)
            ->setMaxResults($value)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $username
     * @param $category
     * @param $district
     * @return Vendor[] Returns an array of Vendor objects
     */
    public function findSearch($username,$category,$district)
    {
        $qb = $this->createQueryBuilder('v')
            ->orderBy('v.username', 'ASC');

            if(!empty($username)){
                $qb->andWhere('v.username LIKE :username')
                ->setParameter(':username', "%$username%");
            }

            if(!empty($category)){
                $qb->innerJoin('v.category', 'cat', 'WITH', "cat.id LIKE :category")
                ->setParameter(':category', "%$category%");
            }

            if(!empty($district)){
                $qb->innerJoin('v.district', 'dis', 'WITH', "dis.id LIKE :district")
                    ->setParameter(':district', "%$district%");
            }

            return $qb

            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Vendor
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
