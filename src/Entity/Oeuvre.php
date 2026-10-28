<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OeuvreRepository::class)]
class Oeuvre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_creation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $est_detruite = null;

    #[ORM\ManyToOne(inversedBy: 'oeuvres')]
    private ?Lieu $id_lieu = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $id_oeuvre_recouverte = null;

    /**
     * @var Collection<int, Photo>
     */
    #[ORM\OneToMany(targetEntity: Photo::class, mappedBy: 'id_oeuvre')]
    private Collection $photos;

    /**
     * @var Collection<int, Artiste>
     */
    #[ORM\ManyToMany(targetEntity: Artiste::class, inversedBy: 'oeuvres')]
    private Collection $id_artiste;

    /**
     * @var Collection<int, Technique>
     */
    #[ORM\ManyToMany(targetEntity: Technique::class, inversedBy: 'oeuvres')]
    private Collection $id_technique;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->id_artiste = new ArrayCollection();
        $this->id_technique = new ArrayCollection();
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

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTime $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isEstDetruite(): ?bool
    {
        return $this->est_detruite;
    }

    public function setEstDetruite(bool $est_detruite): static
    {
        $this->est_detruite = $est_detruite;

        return $this;
    }

    public function getIdLieu(): ?Lieu
    {
        return $this->id_lieu;
    }

    public function setIdLieu(?Lieu $id_lieu): static
    {
        $this->id_lieu = $id_lieu;

        return $this;
    }

    public function getIdOeuvreRecouverte(): ?self
    {
        return $this->id_oeuvre_recouverte;
    }

    public function setIdOeuvreRecouverte(?self $id_oeuvre_recouverte): static
    {
        $this->id_oeuvre_recouverte = $id_oeuvre_recouverte;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setIdOeuvre($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getIdOeuvre() === $this) {
                $photo->setIdOeuvre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getIdArtiste(): Collection
    {
        return $this->id_artiste;
    }

    public function addIdArtiste(Artiste $idArtiste): static
    {
        if (!$this->id_artiste->contains($idArtiste)) {
            $this->id_artiste->add($idArtiste);
        }

        return $this;
    }

    public function removeIdArtiste(Artiste $idArtiste): static
    {
        $this->id_artiste->removeElement($idArtiste);

        return $this;
    }

    /**
     * @return Collection<int, Technique>
     */
    public function getIdTechnique(): Collection
    {
        return $this->id_technique;
    }

    public function addIdTechnique(Technique $idTechnique): static
    {
        if (!$this->id_technique->contains($idTechnique)) {
            $this->id_technique->add($idTechnique);
        }

        return $this;
    }

    public function removeIdTechnique(Technique $idTechnique): static
    {
        $this->id_technique->removeElement($idTechnique);

        return $this;
    }
}
