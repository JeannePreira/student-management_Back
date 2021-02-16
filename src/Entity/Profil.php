<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *      attributes = {
 *          "security" = "is_granted('ROLE_ADMIN')",
 *          "security_message" = "Seules les admin ont accèes à cette ressource!"
 *      },
 *      collectionOperations = {
 *          "getProfil" = {
 *              "method" = "GET",
 *              "path" = "/admin/profils"
 *        
 *          },
 *          "getProfilApprenant" = {
 *              "method" = "GET",
 *              "path" = "/admin/profils/{id}/users"
 *          },
 *          "addProfil" = {
 *              "method" = "POST",
 *              "path" = "/admin/profils"
 *          }
 *      },
 *      itemOperations = {
 *          "getOneProfil" = {
 *              "method" = "GET",
 *              "path" = "/admin/profils/{id}"
 *          },
 *          "putOneProfil" = {
 *              "method" = "PUT",
 *              "path" = "/admin/profils/{id}"
 *          },
 *          "deleteOneProfil" = {
 *              "method" = "Delete",
 *              "path" = "/admin/profils/{id}"
 *          }
 *      }
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"statut": "exact"})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupPut:write"})
     */
    private $id;


    /**
     * @ORM\Column(type="boolean")
     * Groups({"user:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"users:read"})
     * @Assert\NotBlank
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     */
    private $users;

    public function __construct()
    {
        $this->statut = 0;
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
