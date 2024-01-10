<?php

namespace App\Entity;

use App\Repository\CameraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CameraRepository::class)
 */
class Camera
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $connexion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="camera")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=GuideVocal::class, inversedBy="camera")
     */
    private $guideVocal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isConnexion(): ?bool
    {
        return $this->connexion;
    }

    public function setConnexion(bool $connexion): self
    {
        $this->connexion = $connexion;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getuser(): ?User
    {
        return $this->user;
    }

    public function setuser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGuideVocal(): ?GuideVocal
    {
        return $this->guideVocal;
    }

    public function setGuideVocal(?GuideVocal $guideVocal): self
    {
        $this->guideVocal = $guideVocal;

        return $this;
    }
}
