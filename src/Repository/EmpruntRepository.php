<?php

namespace App\Repository;
use DateTimeInterface;
use App\Entity\Livre;
use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }
    // src/Repository/EmpruntRepository.php
public function isLivreDisponible(Livre $livre, \DateTimeInterface $start, \DateTimeInterface $end): bool
{
    $query = $this->createQueryBuilder('e')
        ->select('COUNT(e.id)')
        ->where('e.livre = :livre')
        ->andWhere('e.dateRetour IS NULL OR e.dateRetour >= :start')
        ->setParameter('livre', $livre)
        ->setParameter('start', $start)
        ->getQuery();

    return $query->getSingleScalarResult() === 0;
}
    public function findDateRetour(Livre $livre): ?\DateTimeInterface
    {
        return $this->createQueryBuilder('l')
            ->select('e.dateRetourPrevue')
            ->join('l.emprunts', 'e')
            ->where('l = :livre')
            ->andWhere('e.dateRetour IS NULL')
            ->setParameter('livre', $livre)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }
    
    //    /**
    //     * @return Emprunt[] Returns an array of Emprunt objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Emprunt
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
