<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PayementRepository::class)
 */
class Payement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     */
    private $date_paiement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paiement_valide;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="payement", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(\DateTimeInterface $date_paiement): self
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }

    public function __construct()
    {
        $this->date_paiement = new DateTime();
    }

    public function getPaiementValide(): ?bool
    {
        return $this->paiement_valide;
    }

    public function setPaiementValide(bool $paiement_valide): self
    {
        $this->paiement_valide = $paiement_valide;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }


}

