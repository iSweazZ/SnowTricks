<?php

namespace App\Repository;

use App\Entity\Attachements;
use App\Entity\Tricks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attachements>
 *
 * @method Attachements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attachements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attachements[]    findAll()
 * @method Attachements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attachements::class);
    }

    public function save(Attachements $attachment): void
    {
        try {
            $this->getEntityManager()->beginTransaction();
            $this->getEntityManager()->persist($attachment);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
        } catch (\Exception $e) {
            $this->getEntityManager()->rollback();
        }
    }
}
