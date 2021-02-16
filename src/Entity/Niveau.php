<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 * @ApiResource()
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competences:read","competence:write", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "brief:read", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "brief:read", "briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, inversedBy="niveaux")
     */
    private $livrablepartiel;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="niveaux", cascade = {"persist"})
     *@Groups({"competence:write", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "brief:read", "briefs:read",})
     */
    private $competence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "brief:read", "briefs:read"})
     */
    private $groupeAction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:write", "competences:read", "grpecompetence:write", "grpecompetence:read", "referentiel:write", "referentiel:read", "brief:read", "briefs:read"})
     */
    private $critereEvaluation;

    public function __construct()
    {
        $this->livrablepartiel = new ArrayCollection();
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
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablepartiel(): Collection
    {
        return $this->livrablepartiel;
    }

    public function addLivrablepartiel(LivrablePartiel $livrablepartiel): self
    {
        if (!$this->livrablepartiel->contains($livrablepartiel)) {
            $this->livrablepartiel[] = $livrablepartiel;
        }

        return $this;
    }

    public function removeLivrablepartiel(LivrablePartiel $livrablepartiel): self
    {
        $this->livrablepartiel->removeElement($livrablepartiel);

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

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
}
