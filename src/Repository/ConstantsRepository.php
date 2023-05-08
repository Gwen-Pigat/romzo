<?php

namespace App\Repository;

use App\Entity\Constants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Constants>
 *
 * @method Constants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Constants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Constants[]    findAll()
 * @method Constants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Constants::class);
    }

    public function save(Constants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Constants $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Constants[] Returns an array of Constants objects
     */
    public function findAllByColumn(string $renderCol="nameKey", string $renderValue="value"): array
    {
        $data = $this->createQueryBuilder('c')
            ->select("c.nameKey,c.value")
            ->andWhere('c.isActive = :val')
            ->setParameter('val', true)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        if(empty($data)){
            return $data;
        }
        return array_column($data, $renderValue, $renderCol);
    }

//    public function findOneBySomeField($value): ?Constants
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
