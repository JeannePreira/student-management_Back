<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ApprenantLivrableAttenduRepository;

/**
 * @ORM\Entity(repositoryClass=ApprenantLivrableAttenduRepository::class)
 * @ApiResource(
 *      
 * )
 */
class ApprenantLivrableAttendu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity=LivrableAttendu::class, mappedBy="apprenantLivrableAttendu")
     */
    private $livrableAttendu;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="apprenantLivrableAttendu")
     */
    private $apprenant;

    public function __construct()
    {
        $this->livrableAttendu = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|LivrableAttendu[]
     */
    public function getLivrableAttendu(): Collection
    {
        return $this->livrableAttendu;
    }

    public function addLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if (!$this->livrableAttendu->contains($livrableAttendu)) {
            $this->livrableAttendu[] = $livrableAttendu;
            $livrableAttendu->setApprenantLivrableAttendu($this);
        }

        return $this;
    }

    public function removeLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if ($this->livrableAttendu->removeElement($livrableAttendu)) {
            // set the owning side to null (unless already changed)
            if ($livrableAttendu->getApprenantLivrableAttendu() === $this) {
                $livrableAttendu->setApprenantLivrableAttendu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setApprenantLivrableAttendu($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getApprenantLivrableAttendu() === $this) {
                $apprenant->setApprenantLivrableAttendu(null);
            }
        }

        return $this;
    }
}
