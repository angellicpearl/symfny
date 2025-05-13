<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Livre $livre = null;

    #[ORM\ManyToOne(inversedBy: 'historiqueEmprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateEmprunt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateRetour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): static
    {
        if ($livre !== null) {
            // Mettre à jour la disponibilité du livre (si nécessaire)
            $livre->setDisponible(false); // Supposons que tu aies un champ "disponible" dans l'entité Livre
        }
        $this->livre = $livre;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeImmutable
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(\DateTimeImmutable $dateEmprunt): static
    {
        $this->dateEmprunt = $dateEmprunt;
        return $this;
    }

    public function getDateRetour(): ?\DateTimeImmutable
    {
        return $this->dateRetour;
    }

    public function setDateRetour(\DateTimeImmutable $dateRetour): static
    {
        $this->dateRetour = $dateRetour;
        return $this;
    }

    public function estEnRetard(): bool
    {
        return $this->dateRetour < new \DateTimeImmutable();
    }
    public function findDateRetourActuel(Livre $livre): ?\DateTimeInterface
{
    $result = $this->createQueryBuilder('e')
        ->select('e.dateRetour')
        ->where('e.livre = :livre')
        ->andWhere('e.dateRetour IS NOT NULL')
        ->orderBy('e.dateRetour', 'DESC')
        ->setParameter('livre', $livre)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

    return $result ? $result['dateRetour'] : null;
}
}
