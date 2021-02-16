<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProfilSortieRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 * @ApiResource(
 *      attributes = {
 *          
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "security_message" = "Accès interdit!!"
 *      },
 *      collectionOperations = {
 *          "listerProfilSortie" = {
 *              "method" = "GET",
 *              "path" = "/admin/profilsSorties"
 *          },
 *          "ajoutProfilSortie" = {
 *              "method" = "POST",
 *              "path" = "/admin/profilSortie"
 *          }
 *      },
 *      itemOperations = {
 *          "getOnProfilSortie" = {
 *              "method" = "GET",
 *               "path" = "/admin/profilSorties/{id}"
 *          },
 *          "putOnProfilSortie" = {
 *              "method" = "PUT",
 *               "path" = "/admin/profilSorties/{id}"
 *          },
 *          "deleteOnProfilSortie" = {
 *              "method" = "DELETE",
 *               "path" = "/admin/profilSorties/{id}"
 *          }
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"statut": "exact"})
 */
class ProfilSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="profilSorties")
     */
    private $apprenant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    public function __construct()
    {
        $this->statut = 0;
        $this->apprenant = new ArrayCollection();
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

    public function getStatut(): ?bool
    {

        return $this->statut ;

    }

    public function setStatut(bool $statut): self
    {
        $this->statut = isset($statut) ? $statut:false;
    
        return $this;
    }
}
