<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 *      
 *      collectionOperations = {
 *          "get" = {
 *              "path" = "/admin/competences",
 *               "normalization_context" ={"groups"={"competences:read"}}
 *          },
 *          "post" = {
 *              "path" = "/admin/competences",
 *               "normalization_context" ={"groups"={"comp:read"}},
 *              "denormalization_context" ={"groups"={"competence:write"}},
 *          }
 *      },
 *      itemOperations = {
 *          "get" = {
 *              "path" = "/admin/competences/{id}",
 *               "normalization_context" ={"groups"={"competences:read"}}
 *          },
 *          "put" = {
 *              "path" = "/admin/competences/{id}",
 *              "denormalization_context" ={"groups"={"competence:write"}},
 *          },
 *          "delete" = {
 *              "path" = "/admin/competences/{id}",
 *              "denormalization_context" ={"groups"={"competence:write"}},
 *               }
 *           }
 *)
 * @ApiFilter(SearchFilter::class, properties={"statut": "exact"})
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competences:read","grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade = {"persist"})
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read"})
     */
    private $niveaux;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="competences", cascade = {"persist"})
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $groupeCompetence;

    public function __construct()
    {
        $this->statut = 0;
        $this->niveau = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

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
