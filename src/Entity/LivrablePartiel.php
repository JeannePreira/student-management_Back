<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 * @ApiResource(
 *      collectionOperations = {
 *          "get" = {
 *              "path" = "formateurs/promo/{id}/referentiel/{id1}/competences",
 *               "normalization_context" ={"groups"={"livrable:read"}},
 *              
 *          }
 * 
 * 
 * 
 *      }
 * )
 */
class LivrablePartiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"livrable:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $delai;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $nbreRendu;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="livrablepartiel")
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiel")
     */
    private $apprenantlivrablepartiel;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->apprenantlivrablepartiel = new ArrayCollection();
        
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

    public function getDelai(): ?string
    {
        return $this->delai;
    }

    public function setDelai(?string $delai): self
    {
        $this->delai = $delai;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNbreRendu(): ?string
    {
        return $this->nbreRendu;
    }

    public function setNbreRendu(?string $nbreRendu): self
    {
        $this->nbreRendu = $nbreRendu;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addLivrablepartiel($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            $niveau->removeLivrablepartiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantlivrablepartiel(): Collection
    {
        return $this->apprenantlivrablepartiel;
    }

    public function addApprenantlivrablepartiel(ApprenantLivrablePartiel $apprenantlivrablepartiel): self
    {
        if (!$this->apprenantlivrablepartiel->contains($apprenantlivrablepartiel)) {
            $this->apprenantlivrablepartiel[] = $apprenantlivrablepartiel;
            $apprenantlivrablepartiel->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeApprenantlivrablepartiel(ApprenantLivrablePartiel $apprenantlivrablepartiel): self
    {
        if ($this->apprenantlivrablepartiel->removeElement($apprenantlivrablepartiel)) {
            // set the owning side to null (unless already changed)
            if ($apprenantlivrablepartiel->getLivrablePartiel() === $this) {
                $apprenantlivrablepartiel->setLivrablePartiel(null);
            }
        }

        return $this;
    }
}
