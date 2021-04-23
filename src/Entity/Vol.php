<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VolRepository::class)
 */
class Vol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *  @Assert\NotBlank(message="Merci d'indiquer une date")
     */
    private $date_de_depart;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Merci d'indiquer une date")
     */
    private $date_arrive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci d'indiquer un nom")
     */
    private $nom_aeroport_depart;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Merci d'indiquer un nom")
     */
    private $nom_aeroport_arrive;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Merci d'indiquer un nom")
     */
    private $nom_ville_arrive;
    /**
     * @ORM\Column(type="time")
     */
    private $duree_vol;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $compagnie_depart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $compagnie_retour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $retour_date_de_depart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $retour_date_arrive;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="vols")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $voyage_affaire = false;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut_sejour;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_sejour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="integer")
     */
    private $classe_affaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $classe_economique;

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeDepart(): ?\DateTimeInterface
    {
        return $this->date_de_depart;
    }

    public function setDateDeDepart(\DateTimeInterface $date_de_depart): self
    {
        $this->date_de_depart = $date_de_depart;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->date_arrive;
    }

    public function setDateArrive(\DateTimeInterface $date_arrive): self
    {
        $this->date_arrive = $date_arrive;

        return $this;
    }

    public function getNomAeroportDepart(): ?string
    {
        return $this->nom_aeroport_depart;
    }

    public function setNomAeroportDepart(string $nom_aeroport_depart): self
    {
        $this->nom_aeroport_depart = $nom_aeroport_depart;

        return $this;
    }

    public function getNomAeroportArrive(): ?string
    {
        return $this->nom_aeroport_arrive;
    }

    public function setNomAeroportArrive(string $nom_aeroport_arrive): self
    {
        $this->nom_aeroport_arrive = $nom_aeroport_arrive;

        return $this;
    }

    public function getNomVilleArrive(): ?string
    {
        return $this->nom_ville_arrive;
    }

    public function setNomVilleArrive(string $nom_ville_arrive): self
    {
        $this->nom_ville_arrive = $nom_ville_arrive;

        return $this;
    }
    public function getDureeVol(): ?\DateTimeInterface
    {
        return $this->duree_vol;
    }

    public function setDureeVol(\DateTimeInterface $duree_vol): self
    {
        $this->duree_vol = $duree_vol;

        return $this;
    }

    public function getCompagnieDepart(): ?string
    {
        return $this->compagnie_depart;
    }

    public function setCompagnieDepart(string $compagnie_depart): self
    {
        $this->compagnie_depart = $compagnie_depart;

        return $this;
    }

    public function getCompagnieRetour(): ?string
    {
        return $this->compagnie_retour;
    }

    public function setCompagnieRetour(string $compagnie_retour): self
    {
        $this->compagnie_retour = $compagnie_retour;

        return $this;
    }

    public function getRetourDateDeDepart(): ?\DateTimeInterface
    {
        return $this->retour_date_de_depart;
    }

    public function setRetourDateDeDepart(\DateTimeInterface $retour_date_de_depart): self
    {
        $this->retour_date_de_depart = $retour_date_de_depart;

        return $this;
    }

    public function getRetourDateArrive(): ?\DateTimeInterface
    {
        return $this->retour_date_arrive;
    }

    public function setRetourDateArrive(\DateTimeInterface $retour_date_arrive): self
    {
        $this->retour_date_arrive = $retour_date_arrive;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getVoyageAffaire(): ?bool
    {
        return $this->voyage_affaire;
    }

    public function setVoyageAffaire(bool $voyage_affaire): self
    {
        $this->voyage_affaire = $voyage_affaire;

        return $this;
    }
    

    public function getDateDebutSejour(): ?\DateTimeInterface
    {
        return $this->date_debut_sejour;
    }

    public function setDateDebutSejour(\DateTimeInterface $date_debut_sejour): self
    {
        $this->date_debut_sejour = $date_debut_sejour;

        return $this;
    }

    public function getDateFinSejour(): ?\DateTimeInterface
    {
        return $this->date_fin_sejour;
    }

    public function setDateFinSejour(\DateTimeInterface $date_fin_sejour): self
    {
        $this->date_fin_sejour = $date_fin_sejour;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
    
    public function __toString()
    {
        return $this->pays;
    }

    public function getClasseAffaire(): ?int
    {
        return $this->classe_affaire;
    }

    public function setClasseAffaire(int $classe_affaire): self
    {
        $this->classe_affaire = $classe_affaire;

        return $this;
    }

    public function getClasseEconomique(): ?int
    {
        return $this->classe_economique;
    }

    public function setClasseEconomique(int $classe_economique): self
    {
        $this->classe_economique = $classe_economique;

        return $this;
    }


   




}
