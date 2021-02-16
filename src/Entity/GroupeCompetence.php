<?php

namespace App\Entity;

use App\Entity\Competence;
use App\Entity\Referentiel;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;


/**
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 *  @ApiResource(
 *       denormalizationContext ={"groups"={"grpecompetence:write"}},
 *       collectionOperations = {
 *          "get" = {
 *              "path" = "/admin/grpecompetences",
 *              "normalization_context" ={"groups"={"grpecompetence:read"}}
 *           },
 *          "GET" = {
 *              "path" = "/admin/grpecompetences/competences",
 *              "normalization_context" ={"groups"={"grpecompetence:read"}}
 *           },
 *          "POST" = {
 *              "path" = "/admin/grpecompetences",
 *              "normalization_context"={"groups"={"grpecompetence:read"}}
 *           }
 *      },
 *      itemOperations = {
 *          "GET" = {
 *              "path" = "/admin/grpecompetences/{id}",
 *              "normalization_context" ={"groups"={"grpecompetence:read"}}
 *          },
 *          "get" = {
 *              "path" = "/admin/grpecompetences/{id}/competences",
 *              "normalization_context" ={"groups"={"grpecompetence:read"}}
 *          },
 *          "put" = {
 *              "path" = "/admin/grpecompetences/{id}"
 *          },
 *          "delete" = {
 *              "path" = "/admin/grpecompetences/{id}"
 *          }
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"statut": "exact"})
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read", "referentiel:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetence")
     * 
     */
    private $referentiels;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="groupeCompetence", cascade = {"persist"})
     * @Groups({"grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $competences;

    public function __construct()
    {
        $this->statut = 0;
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->competences = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = isset($statut) ? $statut:false;

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            $competence->removeGroupeCompetence($this);
        }

        return $this;
    }


}
