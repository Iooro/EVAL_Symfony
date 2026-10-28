<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_prise_vue = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_fichier = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $etat_oeuvre = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Oeuvre $id_oeuvre = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Benevole $id_benevole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePriseVue(): ?\DateTime
    {
        return $this->date_prise_vue;
    }

    public function setDatePriseVue(\DateTime $date_prise_vue): static
    {
        $this->date_prise_vue = $date_prise_vue;

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nom_fichier;
    }

    public function setNomFichier(string $nom_fichier): static
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    public function getEtatOeuvre(): ?string
    {
        return $this->etat_oeuvre;
    }

    public function setEtatOeuvre(string $etat_oeuvre): static
    {
        $this->etat_oeuvre = $etat_oeuvre;

        return $this;
    }

    public function getIdOeuvre(): ?Oeuvre
    {
        return $this->id_oeuvre;
    }

    public function setIdOeuvre(?Oeuvre $id_oeuvre): static
    {
        $this->id_oeuvre = $id_oeuvre;

        return $this;
    }

    public function getIdBenevole(): ?Benevole
    {
        return $this->id_benevole;
    }

    public function setIdBenevole(?Benevole $id_benevole): static
    {
        $this->id_benevole = $id_benevole;

        return $this;
    }
}
