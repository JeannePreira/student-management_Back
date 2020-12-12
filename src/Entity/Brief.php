<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 * @ApiResource(
 *      collectionOperations = {
 *          "get" = {
 *              "path" = "/formateurs/briefs",
 *              "normalization_context" = {"groups" = {"brief:read"}}
 *          },
 *          "getBriefbygroupe" = {
 *              "method" = "GET",
 *              "path" = "/formateurs/promo/{id}/groupe/{ID}/briefs",
 *              "normalization_context" = {"groups" = {"briefs:read"}}
 *          }
 *      },
 *      itemOperations = {
 *          "getBriefbypromo" = {
 *              "method" = "GET",
 *              "path" = "/formateurs/promo/{id}/briefs/{ID}",
 *              "normalization_context" = {"groups" = {"briefs:read"}}
 *          }
 *      }
 * )
 */
class Brief
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"brief:read", "brief:write", "briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write", "briefs:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:read", "brief:write", "briefs:read"})
     */
    private $nomBrief;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $context;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * 
     */
    private $imagePromo;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $archiver;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"brief:write", "briefs:read"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=LivrableAttendu::class, mappedBy="brief")
     * @Groups({"brief:write", "brief:read", "briefs:read"})
     */
    private $livrableAttendus;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     * @Groups({"brief:write", "brief:read", "briefs:read"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="briefs")
     * @Groups({"brief:read", "briefs:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="brief")
     * 
     */
    private $resource;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="brief")
     * @Groups({"briefs:read"})
     */
    private $briefmapromo;

    public function __construct()
    {
        $this->livrableAttendus = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->resource = new ArrayCollection();
        $this->briefmapromo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomBrief(): ?string
    {
        return $this->nomBrief;
    }

    public function setNomBrief(string $nomBrief): self
    {
        $this->nomBrief = $nomBrief;

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

    public function getContext(): ?string
    {
        return $this->context;
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getImagePromo()
    {
        return $this->imagePromo;
    }

    public function setImagePromo($imagePromo): self
    {
        $this->imagePromo = $imagePromo;

        return $this;
    }

    public function getArchiver(): ?bool
    {
        return $this->archiver;
    }

    public function setArchiver(bool $archiver): self
    {
        $this->archiver = $archiver;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    /**
     * @return Collection|LivrableAttendu[]
     */
    public function getLivrableAttendus(): Collection
    {
        return $this->livrableAttendus;
    }

    public function addLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if (!$this->livrableAttendus->contains($livrableAttendu)) {
            $this->livrableAttendus[] = $livrableAttendu;
            $livrableAttendu->addBrief($this);
        }

        return $this;
    }

    public function removeLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if ($this->livrableAttendus->removeElement($livrableAttendu)) {
            $livrableAttendu->removeBrief($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        $this->niveau->removeElement($niveau);

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getResource(): Collection
    {
        return $this->resource;
    }

    public function addResource(Ressource $resource): self
    {
        if (!$this->resource->contains($resource)) {
            $this->resource[] = $resource;
            $resource->setBrief($this);
        }

        return $this;
    }

    public function removeResource(Ressource $resource): self
    {
        if ($this->resource->removeElement($resource)) {
            // set the owning side to null (unless already changed)
            if ($resource->getBrief() === $this) {
                $resource->setBrief(null);
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
            $briefmapromo->setBrief($this);
        }

        return $this;
    }

    public function removeBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if ($this->briefmapromo->removeElement($briefmapromo)) {
            // set the owning side to null (unless already changed)
            if ($briefmapromo->getBrief() === $this) {
                $briefmapromo->setBrief(null);
            }
        }

        return $this;
    }
}
