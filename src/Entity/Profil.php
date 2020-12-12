<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
     */
    private $statut;

   

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"groupPut:write"})
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    public function __construct()
    {
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
        $this->statut = $statut;

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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
