<?php

namespace App\Repository;

use App\Entity\ResumeSectionItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * @method ResumeSectionItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResumeSectionItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeSectionItem[]    findAll()
 * @method ResumeSectionItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeSectionItemRepository extends SortableRepository
{
    public function __construct(RegistryInterface $registry)
    {
        $entityClass = ResumeSectionItem::class;
        $manager     = $registry->getManagerForClass($entityClass);

        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }

    // /**
    //  * @return ResumeSectionItem[] Returns an array of ResumeSectionItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResumeSectionItem
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
