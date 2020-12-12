<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


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
 *              "path" = "/admin/grpecompetences"
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
 *          }
 *      }
 * )
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences", cascade={"persist"})
     * @Groups({"grpecompetence:write", "grpecompetence:read", "briefs:read"})
     * 
     */
    private $competence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="groupecompetence",cascade = {"persist"})
     * @Groups({"grpecompetence:write", "briefs:read"})
     */
    private $referentiel;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
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

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

}
