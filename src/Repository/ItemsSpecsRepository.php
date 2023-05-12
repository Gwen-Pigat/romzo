<?php

namespace App\Repository;

use App\Entity\ItemsSpecs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemsSpecs>
 *
 * @method ItemsSpecs|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsSpecs|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsSpecs[]    findAll()
 * @method ItemsSpecs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsSpecsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsSpecs::class);
    }

    public function save(ItemsSpecs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ItemsSpecs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ItemsSpecs[] Returns an array of Constants objects
     */
    public function findAllItemsSpecs(bool $isActiveOnly=true): array
    {
        $query = $this->createQueryBuilder('i')
            ->select("i.id,i.name,i.placement,i.isActive");
        if($isActiveOnly === true) {
            $query->andWhere('i.isActive = :val')
                ->setParameter('val', true);
        }
        return $query->orderBy('i.placement', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findOneItemsSpecs(int $id, bool $isActiveOnly=true): ?ItemsSpecs
    {
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.id = :id');
        if($isActiveOnly === true) {
            $query->andWhere('i.isActive = :val')
                ->setParameter('val', true);
        }
        return $query->setParameter('id', $id)
        ->getQuery()
        ->setMaxResults(1)
        ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return ItemsSpecs[] Returns an array of ItemsSpecs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemsSpecs
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
