<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 *      denormalizationContext ={"groups"={"groupe:write"}},
 *      attributes = {
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "security_message" = "Accès refusé!"
 *      },
 *      collectionOperations = {
 *          "get_groupes"={
 *              "method" = "get",
 *              "path" = "/admin/groupes",
 *              "normalization_context"={"groups"={"groupe:read"}}
 *          },
 *          "get_groupes_apprenants"={
 *              "method" = "get",
 *              "path" = "admin/groupes/apprenants",
 *              "normalization_context"={"groups"={"groupeApp:read"}}
 *          },
 *          "addGroupes"={
 *              "method" = "POST",
 *              "path" = "admin/groupes",
 *              "denormalization_context" ={"groups"={"group:write"}}
 *          }
 *      },
 *       itemOperations = {
 *          "get"={
 *              "path" = "/admin/groupes/{id}",
 *              "normalization_context"={"groups"={"groupe:read"}}
 *          },
 *          "put"={
 *              "path" = "/admin/groupes/{id}",
 *              "denormalization_context" ={"groups"={"groupPut:write"}}
 *          }
 *      }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read", "groupeApp:read", "groupPut:write", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:write", "groupe:read", "groupeApp:read", "groupPut:write", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     * @Groups({"group:write","groupe:read", "groupPut:write"})
     * @ApiSubresource 
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes",cascade={"persist"}))
     * @Groups({"group:write", "groupe:read", "groupeApp:read", "groupPut:write", "briefs:read"})
     * @ApiSubresource
     */
    private $apprenant;
    
    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     * @Groups({"group:write", "groupe:read", "groupPut:write", "briefs:read"})
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupe")
     * @Groups({"group:write", "groupPut:write"})
     */
    private $etatbriefgroupe;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
        $this->etatbriefgroupe = new ArrayCollection();
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

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

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
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenant->removeElement($apprenant);

        return $this;
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

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatbriefgroupe(): Collection
    {
        return $this->etatbriefgroupe;
    }

    public function addEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if (!$this->etatbriefgroupe->contains($etatbriefgroupe)) {
            $this->etatbriefgroupe[] = $etatbriefgroupe;
            $etatbriefgroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if ($this->etatbriefgroupe->removeElement($etatbriefgroupe)) {
            // set the owning side to null (unless already changed)
            if ($etatbriefgroupe->getGroupe() === $this) {
                $etatbriefgroupe->setGroupe(null);
            }
        }

        return $this;
    }
}
