<?php

namespace App\Repository;

use App\Entity\ItemsSpecsItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemsSpecsItems>
 *
 * @method ItemsSpecsItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemsSpecsItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemsSpecsItems[]    findAll()
 * @method ItemsSpecsItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemsSpecsItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemsSpecsItems::class);
    }

    public function save(ItemsSpecsItems $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ItemsSpecsItems $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ItemsSpecsItems[] Returns an array of ItemsSpecsItems objects
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

//    public function findOneBySomeField($value): ?ItemsSpecsItems
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
