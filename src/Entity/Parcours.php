<?php

namespace App\Entity;

use App\Repository\ParcoursRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParcoursRepository::class)
 */
class Parcours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuDeDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_d_arrivee;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_de_depart;

    /**
     * @ORM\Column(type="time")
     */
    private $heure_d_arrivee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieuDeDepart(): ?string
    {
        return $this->lieuDeDepart;
    }

    public function setLieuDeDepart(string $lieuDeDepart): self
    {
        $this->lieuDeDepart = $lieuDeDepart;

        return $this;
    }

    public function getLieuDArrivee(): ?string
    {
        return $this->lieu_d_arrivee;
    }

    public function setLieuDArrivee(string $lieu_d_arrivee): self
    {
        $this->lieu_d_arrivee = $lieu_d_arrivee;

        return $this;
    }

    public function getHeureDeDepart(): ?\DateTimeInterface
    {
        return $this->heure_de_depart;
    }

    public function setHeureDeDepart(\DateTimeInterface $heure_de_depart): self
    {
        $this->heure_de_depart = $heure_de_depart;

        return $this;
    }

    public function getHeureDArrivee(): ?\DateTimeInterface
    {
        return $this->heure_d_arrivee;
    }

    public function setHeureDArrivee(\DateTimeInterface $heure_d_arrivee): self
    {
        $this->heure_d_arrivee = $heure_d_arrivee;

        return $this;
    }
}
