<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *          }
 *      }
 *)
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade = {"persist"})
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read"})
     */
    private $niveaux;

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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

}
