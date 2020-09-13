<?php

namespace App\Repository;

use App\Entity\VideoAlternative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoAlternative|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoAlternative|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoAlternative[]    findAll()
 * @method VideoAlternative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoAlternativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoAlternative::class);
    }

    public function findAllVideoAlternativesForVideo(string $videoId): array
    {
        return $this->createQueryBuilder('va')
            ->andWhere('va.videoId = :val')
            ->setParameter('val', $videoId)
            ->orderBy('va.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return VideoAlternative[] Returns an array of VideoAlternative objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('va')
            ->andWhere('va.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('va.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoAlternative
    {
        return $this->createQueryBuilder('va')
            ->andWhere('va.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
