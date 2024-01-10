<?php

namespace App\Entity;

use App\Repository\GuideVocalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuideVocalRepository::class)
 */
class GuideVocal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $voix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_accompagnement;

    /**
     * @ORM\OneToMany(targetEntity=Camera::class, mappedBy="guideVocal")
     */
    private $camera;

    public function __construct()
    {
        $this->camera = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoix(): ?string
    {
        return $this->voix;
    }

    public function setVoix(string $voix): self
    {
        $this->voix = $voix;

        return $this;
    }

    public function getNiveauAccompagnement(): ?string
    {
        return $this->niveau_accompagnement;
    }

    public function setNiveauAccompagnement(string $niveau_accompagnement): self
    {
        $this->niveau_accompagnement = $niveau_accompagnement;

        return $this;
    }

    /**
     * @return Collection<int, Camera>
     */
    public function getCamera(): Collection
    {
        return $this->camera;
    }

    public function addCamera(Camera $camera): self
    {
        if (!$this->camera->contains($camera)) {
            $this->camera[] = $camera;
            $camera->setGuideVocal($this);
        }

        return $this;
    }

    public function removeCamera(Camera $camera): self
    {
        if ($this->camera->removeElement($camera)) {
            // set the owning side to null (unless already changed)
            if ($camera->getGuideVocal() === $this) {
                $camera->setGuideVocal(null);
            }
        }

        return $this;
    }
}
