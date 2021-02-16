<?php

namespace App\Entity;

use App\Entity\Promo;
use Symfony\Component\Validator\Constraints as Assert;
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
 *          "adReferentiel" = {
 *              "method": "POST",
 *              "path" = "/admin/referentiel",
 *              "normalization_context" = {"groups"={"referentiel:write"}},
 *               "deserialize" = false
 *           }
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel", cascade = {"persist"})
     * @Groups({"referentiel:write"})
     */
    private $promos;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob")
     */
    private $programme;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $deleted;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="referentiels")
     * @Groups({"groupe:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $groupeCompetence;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->groupecompetence = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->groupeCompetence = new ArrayCollection();
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

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme()
    {
        return $this->programme;
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }
}
