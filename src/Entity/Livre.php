<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Genre;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[ORM\Column]
    private ?bool $disponible = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Auteur $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Genre $genre = null;

    /**
     * @var Collection<int, Emprunt>
     */
    #[ORM\OneToMany(targetEntity: Emprunt::class, mappedBy: 'livre')]
    private Collection $emprunts;
        /**

    * @ORM\Column(type="string", length=255, nullable=true)
    */
   #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Critique>
     * @ORM\OneToMany(targetEntity="App\Entity\Critique", mappedBy="livre")
     */
    private Collection $critiques;


    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
    }
    
    public function getCritiques(): Collection
    {
        return $this->critiques;
    }

    public function addCritique(Critique $critique): self
    {
        if (!$this->critiques->contains($critique)) {
            $this->critiques[] = $critique;
            $critique->setLivre($this);
        }

        return $this;
    }

    public function removeCritique(Critique $critique): self
    {
        if ($this->critiques->removeElement($critique)) {
            if ($critique->getLivre() === $this) {
                $critique->setLivre(null);
            }
        }

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    // src/Entity/Livre.php
public function isDisponible(): bool
{
    foreach ($this->emprunts as $emprunt) {
        // Si un emprunt n'a pas de date de retour OU que la date de retour est dans le futur
        if (null === $emprunt->getDateRetour() || $emprunt->getDateRetour() > new \DateTime()) {
            return false;
        }
    }
    return true;
}
    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }
    
    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;
    
        return $this;
    }
    

    public function getGenre(): ?genre
    {
        return $this->genre;
    }

    public function setGenre(?genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunt(): Collection
    {
        return $this->emprunt;
    }

    public function addEmprunt(Emprunt $emprunt): static
    {
        if (!$this->emprunt->contains($emprunt)) {
            $this->emprunt->add($emprunt);
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }
    public function removeEmprunt(Emprunt $emprunt): static
    {
        if ($this->emprunt->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }
    public function estEmpruntable(): bool
{
    return $this->disponible === true;
}
// src/Entity/Livre.php
public function getProchainRetour(): ?\DateTimeInterface
{
    if (!$this->emprunts->isEmpty()) {
        // Trouve le premier emprunt actif (sans date de retour)
        foreach ($this->emprunts as $emprunt) {
            if (null === $emprunt->getDateRetour()) {
                return $emprunt->getDateRetour();
            }
        }
    }
    return null;
}

}
