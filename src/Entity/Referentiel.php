<?php

namespace App\Entity;

use App\Entity\Promo;
use App\Entity\GroupeCompetence;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      denormalizationContext ={"groups"={"referentiel:write"}},
 *      collectionOperations = {
 *          "GET" = {
 *              "path": "admin/referentiel",
 *              "normalization_context" = {"groups"={"referentiel:read"}}
 *          },
 *          "get" = {
 *              "path": "/admin/referentiel/grpecompetences",
 *              "normalization_context" = {"groups"={"referentiel:read"}}
 *          },
 *          "POST" = {
 *              "path": "/admin/referentiel"
 *          }
 *      },
 *      itemOperations = {
 *          "get"= {
 *              "path": "/admin/referentiel/{id}",
 *              "normalization_context" = {"groups"={"referentiel:read"}}
 *          },
 *          "GET"= {
 *              "path": "/admin/referentiel/{id}/grpecompetence/{ID}",
 *              "normalization_context" = {"groups"={"referentiel:read"}}
 *          },
 *          "put"= {
 *              "path": "/admin/referentiel/{id}",
 *              "normalization_context" = {"groups"={"referentiel:read"}}
 *          },
 *          
 *      }
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpecompetence:write", "groupe:read", "referentiel:read", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel", cascade = {"persist"})
     * @Groups({"referentiel:write"})
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=GroupeCompetence::class, mappedBy="referentiel", cascade = {"persist"})
     * @Groups({"grpecompetence:write", "referentiel:write", "referentiel:read"})
     */
    private $groupecompetence;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->groupecompetence = new ArrayCollection();
        $this->promos = new ArrayCollection();
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
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupecompetence(): Collection
    {
        return $this->groupecompetence;
    }

    public function addGroupecompetence(GroupeCompetence $groupecompetence): self
    {
        if (!$this->groupecompetence->contains($groupecompetence)) {
            $this->groupecompetence[] = $groupecompetence;
            $groupecompetence->setReferentiel($this);
        }

        return $this;
    }

    public function removeGroupecompetence(GroupeCompetence $groupecompetence): self
    {
        if ($this->groupecompetence->removeElement($groupecompetence)) {
            // set the owning side to null (unless already changed)
            if ($groupecompetence->getReferentiel() === $this) {
                $groupecompetence->setReferentiel(null);
            }
        }

        return $this;
    }
}
