<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefMaPromoRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"briefs:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="briefmapromo")
     * @Groups({"briefs:read"})
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefmapromo")
     */
    private $brief;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }
}
