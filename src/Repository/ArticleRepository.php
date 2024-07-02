<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getLastArticle(): ?Article
    {
        $qb = $this->createQueryBuilder('a');
        $qb->orderBy('a.created', 'DESC');
        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function searchArticles(?string $search = ""): ?array

    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('LOWER(a.title) LIKE LOWER(:search)');
        $qb->orwhere('LOWER(a.content) LIKE LOWER(:search)');
        $qb->setParameter('search', '%' . $search . '%');
        $qb->orderBy('a.created', 'DESC');

        return $qb->getQuery()->getResult();
    }

//    public function getArticle(Int $id): ?Article
//    {
//        $qb = $this->createQueryBuilder('a');
//        $qb->where('a.id = :id');
//
//    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
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

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
