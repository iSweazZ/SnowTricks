<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Exception;

/**
 * @extends ServiceEntityRepository<Comments>
 *
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    public function save(Comments $entity): void
    {

        $entityManager = $this->getEntityManager();

        try {
            $entityManager->beginTransaction();
            $entityManager->persist($entity);
            $entityManager->flush();
            $entityManager->commit();
        }catch(Exception $e)
        {
            $entityManager->rollback();
        }
    }

    public function remove(Comments $entity, bool $flush = false): void
    {
        $entityManager = $this->getEntityManager();

        try {
            $entityManager->beginTransaction();
            $entityManager->remove($entity);
            $entityManager->flush();
            $entityManager->commit();
        }catch(Exception $e)
        {
            $entityManager->rollback();
        }
    }

//    /**
//     * @return Comments[] Returns an array of Comments objects
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

//    public function findOneBySomeField($value): ?Comments
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
