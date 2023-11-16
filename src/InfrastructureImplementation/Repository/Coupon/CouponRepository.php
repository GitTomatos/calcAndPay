<?php

namespace App\InfrastructureImplementation\Repository\Coupon;

use App\Domain\Entity\Coupon\Coupon;
use App\InfrastructureInterface\Repository\Coupon\CouponRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 *
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponRepository extends ServiceEntityRepository implements CouponRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }

    public function getByPromocode(string $promocode): ?Coupon
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->andWhere(
                $qb->expr()->eq('c.promocode', ":promocode"),
            )
            ->setParameter('promocode', $promocode);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Coupon[] Returns an array of Coupon objects
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

//    public function findOneBySomeField($value): ?Coupon
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
