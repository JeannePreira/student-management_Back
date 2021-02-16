<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 *     collectionOperations = {
 *          "get" = {
 *              "path" = "/admin/promo",
 *              "normalization_context"={"groups"={"promo:read"}}
 *          },
 *          "GET" = {
 *              "path" = "/admin/promo/principal",
 *              "normalization_context"={"groups"={"promoApp:read"}}
 *          },
 *          "POST" = {
 *              "path" = "/admin/promo",
 *              "denormalization_context"={"groups"={"promoApp:write"}}
 *          } 
 *      },
 *      itemOperations = {
 *          "getPromo" = {
 *              "method"="get",
 *              "path" = "/admin/promo/{id}",
 *              "normalization_context"={"groups"={"promo:read"}}
 *          },
 *          "getGroupePrincipal" = {
 *              "method"="get",
 *              "path" = "/admin/promo/{id}/principal",
 *              "normalization_context"={"groups"={"groupePrincipal:read"}}
 *          },
 *          "getref" = {
 *              "method"="get",
 *              "path" = "/admin/promo/{id}/referentiel",
 *              "normalization_context"={"groups"={"promoRef:read"}}
 *          },
 *          "getOneApprenant" = {
 *              "method"="get",
 *              "path" = "/admin/promo/{id}/groupe/{ID}/apprenants",
 *              "nonantrmalization_context"={"groups"={"promoOneApp:read"}}
 *          },
 *          "getOneformateur" = {
 *              "method"="get",
 *              "path" = "/admin/promo/{id}/groupe/{ID}/formateurs",
 *              "normalization_context"={"groups"={"promoOneformateur:read"}}
 *          },
 *          "modifReferentiel&Promo" = {
 *              "method"="put",
 *              "path" = "/admin/promo/{id}/referentiel",
 *              "denormalization_context"={"groups"={"promoRef:write"}}
 *          },
 *          "modifApprenantByPromo" = {
 *              "method"="put",
 *              "path" = "/admin/promo/{id}/apprenants",
 *              "denormalization_context"={"groups"={"promoApp:write"}}
 *          },
 *          "modifFormateurByPromo" = {
 *              "method"="put",
 *              "path" = "/admin/promo/{id}/foramteurs",
 *              "denormalization_context"={"groups"={"promoFormateur:write"}}
 *          },
 *          "modifGroupeByPromo" = {
 *              "method"="put",
 *              "path" = "/admin/promo/{id}/groupes/{ID}",
 *              "denormalization_context"={"groups"={"promoFormateur:write"}}
 *          }
 *      }
 * )
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group:write", "groupe:read", "groupPut:write", "referentiel:write", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "referentiel:write", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $fabrique;

    /**
     * @ORM\Column(type="date")

     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * 
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $langue;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"group:write"})
     */
    private $groupes;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos", cascade = {"persist"})
     * @Groups({"referentiel:write"})
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promo")
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValide::class, mappedBy="promo")
     */
    private $competencevalide;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="promo")
     */
    private $briefmapromo;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->promo = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->competenceValides = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->chat = new ArrayCollection();
        $this->competencevalide = new ArrayCollection();
        $this->briefmapromo = new ArrayCollection();
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReferenceAgate(): ?string
    {
        return $this->referenceAgate;
    }

    public function setReferenceAgate(string $referenceAgate): self
    {
        $this->referenceAgate = $referenceAgate;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setPromo($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getPromo() === $this) {
                $chat->setPromo(null);
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
            $competencevalide->setPromo($this);
        }

        return $this;
    }

    public function removeCompetencevalide(CompetenceValide $competencevalide): self
    {
        if ($this->competencevalide->removeElement($competencevalide)) {
            // set the owning side to null (unless already changed)
            if ($competencevalide->getPromo() === $this) {
                $competencevalide->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefmapromo(): Collection
    {
        return $this->briefmapromo;
    }

    public function addBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if (!$this->briefmapromo->contains($briefmapromo)) {
            $this->briefmapromo[] = $briefmapromo;
            $briefmapromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if ($this->briefmapromo->removeElement($briefmapromo)) {
            // set the owning side to null (unless already changed)
            if ($briefmapromo->getPromo() === $this) {
                $briefmapromo->setPromo(null);
            }
        }

        return $this;
    }

}
