<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *      attributes ={
 *          "pagination_items_per_page" = 2,
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "security_message" = "Accès refusée!!!" 
 *      },
 *      collectionOperations = {
 *          "getApprenant" = {
 *              "method": "GET",
 *              "path": "/apprenants"
 *          }
 *      },
 *      itemOperations = {
 *          "get" = {
 *             "path": "/apprenants/{id}" 
 *          }
 *      }
 * )
 */
class Apprenant extends User
{

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "groupeApp:read"})
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=ProfilSortie::class, mappedBy="apprenant")
     */
    private $profilSorties;

    /**
     * @ORM\Column(type="boolean")
     */
    private $attente;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="apprenant")
     */
    private $briefapprenant;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="apprenant")
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValide::class, mappedBy="apprenant")
     */
    private $competencevalide;

    /**
     * @ORM\ManyToOne(targetEntity=ApprenantLivrableAttendu::class, inversedBy="apprenant")
     */
    private $apprenantLivrableAttendu;

    public function __construct()
    {
        $this->profilSorties = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->briefapprenant = new ArrayCollection();
        $this->apprenantLivrablePartiels = new ArrayCollection();
        $this->competencevalide = new ArrayCollection();
    }


    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|ProfilSortie[]
     */
    public function getProfilSorties(): Collection
    {
        return $this->profilSorties;
    }

    public function addProfilSorty(ProfilSortie $profilSorty): self
    {
        if (!$this->profilSorties->contains($profilSorty)) {
            $this->profilSorties[] = $profilSorty;
            $profilSorty->addApprenant($this);
        }

        return $this;
    }

    public function removeProfilSorty(ProfilSortie $profilSorty): self
    {
        if ($this->profilSorties->removeElement($profilSorty)) {
            $profilSorty->removeApprenant($this);
        }

        return $this;
    }

    public function getAttente(): ?bool
    {
        return $this->attente;
    }

    public function setAttente(bool $attente): self
    {
        $this->attente = $attente;

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefapprenant(): Collection
    {
        return $this->briefapprenant;
    }

    public function addBriefapprenant(BriefApprenant $briefapprenant): self
    {
        if (!$this->briefapprenant->contains($briefapprenant)) {
            $this->briefapprenant[] = $briefapprenant;
            $briefapprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeBriefapprenant(BriefApprenant $briefapprenant): self
    {
        if ($this->briefapprenant->removeElement($briefapprenant)) {
            // set the owning side to null (unless already changed)
            if ($briefapprenant->getApprenant() === $this) {
                $briefapprenant->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantLivrablePartiels(): Collection
    {
        return $this->apprenantLivrablePartiels;
    }

    public function addApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if (!$this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels[] = $apprenantLivrablePartiel;
            $apprenantLivrablePartiel->setApprenant($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel)) {
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getApprenant() === $this) {
                $apprenantLivrablePartiel->setApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetenceValide[]
     */
    public function getCompetencevalide(): Collection
    {
        return $this->competencevalide;
    }

    public function addCompetencevalide(CompetenceValide $competencevalide): self
    {
        if (!$this->competencevalide->contains($competencevalide)) {
            $this->competencevalide[] = $competencevalide;
            $competencevalide->setApprenant($this);
        }

        return $this;
    }

    public function removeCompetencevalide(CompetenceValide $competencevalide): self
    {
        if ($this->competencevalide->removeElement($competencevalide)) {
            // set the owning side to null (unless already changed)
            if ($competencevalide->getApprenant() === $this) {
                $competencevalide->setApprenant(null);
            }
        }

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
