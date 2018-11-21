<?php

namespace App\Repository;

use App\Entity\ResumeSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * @method ResumeSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResumeSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResumeSection[]    findAll()
 * @method ResumeSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeSectionRepository extends SortableRepository
{
    public function __construct(RegistryInterface $registry)
    {
        $entityClass = ResumeSection::class;
        $manager     = $registry->getManagerForClass($entityClass);

        parent::__construct($manager, $manager->getClassMetadata($entityClass));
    }

    // /**
    //  * @return ResumeSection[] Returns an array of ResumeSection objects
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
    public function findOneBySomeField($value): ?ResumeSection
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
