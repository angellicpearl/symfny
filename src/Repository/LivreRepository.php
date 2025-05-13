<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function findByFilters(?string $titre, ?string $auteur): array
{
    $queryBuilder = $this->createQueryBuilder('l')
        ->leftJoin('l.auteur', 'a');  // Joindre l'entité Auteur

    // Filtrer par titre
    if ($titre) {
        $queryBuilder->andWhere('l.titre LIKE :titre')
                     ->setParameter('titre', '%' . $titre . '%');
    }

    // Filtrer par auteur seulement si la variable $auteur n'est pas vide
    if ($auteur) {
        $queryBuilder->andWhere('a.nom LIKE :auteur')
                     ->setParameter('auteur', '%' . $auteur . '%');
    }

    return $queryBuilder->getQuery()->getResult();
}
public function findProchainRetour(Livre $livre): ?\DateTimeInterface
{
    return $this->createQueryBuilder('l')
        ->select('e.dateRetour')
        ->join('l.emprunts', 'e')
        ->where('l = :livre')
        ->andWhere('e.dateRetour IS NOT NULL')
        ->orderBy('e.dateRetour', 'DESC')
        ->setMaxResults(1)
        ->setParameter('livre', $livre)
        ->getQuery()
        ->getSingleScalarResult();
}
// src/Repository/LivreRepository.php
public function findDateRetour(Livre $livre): ?\DateTimeInterface
{
    $result = $this->createQueryBuilder('l')
        ->select('e.dateRetour')  // Sélectionne le champ dateRetour
        ->join('l.emprunts', 'e')
        ->where('l = :livre')
        ->andWhere('e.dateRetour IS NOT NULL')  // Cherche les emprunts avec date de retour définie
        ->orderBy('e.dateRetour', 'DESC')  // Prend la plus récente
        ->setParameter('livre', $livre)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

    return $result ? $result['dateRetour'] : null;
}
}

   