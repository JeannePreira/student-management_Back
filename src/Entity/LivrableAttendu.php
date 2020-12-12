<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\LivrableAttenduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrableAttenduRepository::class)
 */
class LivrableAttendu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"brief:write", "brief:read", "brief:read", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="livrableAttendus")
     * @Groups({"brief:write"})
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=ApprenantLivrableAttendu::class, inversedBy="livrableAttendu")
     */
    private $apprenantLivrableAttendu;

    public function __construct()
    {
        $this->brief = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBrief(): Collection
    {
        return $this->brief;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->brief->contains($brief)) {
            $this->brief[] = $brief;
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        $this->brief->removeElement($brief);

        return $this;
    }

    public function getApprenantLivrableAttendu(): ?ApprenantLivrableAttendu
    {
        return $this->apprenantLivrableAttendu;
    }

    public function setApprenantLivrableAttendu(?ApprenantLivrableAttendu $apprenantLivrableAttendu): self
    {
        $this->apprenantLivrableAttendu = $apprenantLivrableAttendu;

        return $this;
    }
}
