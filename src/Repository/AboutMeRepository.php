<?php

namespace App\Repository;

use App\Entity\AboutMeInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<AboutMeInfo>
 *
 * @method AboutMeInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutMeInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutMeInfo[]    findAll()
 * @method AboutMeInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutMeRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, AboutMeInfo::class);
        $this->entityManager = $entityManager;
    }

    public function insert(AboutMeInfo $info): void
    {
        $this->entityManager->persist($info);
        $this->entityManager->flush();
    }

    //    /**
    //     * @return AboutMeInfo[] Returns an array of AboutMeInfo objects
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

    //    public function findOneBySomeField($value): ?AboutMeInfo
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
