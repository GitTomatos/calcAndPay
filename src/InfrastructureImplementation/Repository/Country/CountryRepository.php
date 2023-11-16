<?php

namespace App\InfrastructureImplementation\Repository\Country;

use App\Domain\Entity\Country\Country;
use App\InfrastructureInterface\Repository\Country\CountryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Country>
 *
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository implements CountryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function getByCode(string $countryCode): ?Country
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->andWhere(
                $qb->expr()->like('c.taxNumberTemplate', ":countryCode"),
            )
            ->setParameter('countryCode', "$countryCode%");

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }
//    /**
//     * @return Country[] Returns an array of Country objects
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

//    public function findOneBySomeField($value): ?Country
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
