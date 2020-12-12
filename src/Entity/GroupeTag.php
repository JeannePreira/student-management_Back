<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 * @ApiResource(
 *       collectionOperations = {
 *          "get" = {
 *              "path" = "/admin/grptags"
 *          },
 *          "addTag" = {
 *              "method" = "POST",
 *              "path" = "/admin/grptags",
 *              "denormalization_context" = {"groups" = {"grptags:write"}}
 *          }
 *      },
 *      itemOperations = {
 *          "get" = {
 *              "path" = "/admin/grptags/{id}"
 *          },
 *          "getTags" = {
 *              "method" = "GET",
 *              "path" = "/admin/grptags/{id}/tags"
 *          },
 *          "putTag" = {
 *              "method" = "PUT",
 *              "path" = "/admin/grptags/{id}",
 *              "denormalization_context" = {"groups" = {"grptags:write"}}
 *          }
 *      }
 * )
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tag:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tag:write", "grptags:write"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags", cascade={"persist"})
     * @Groups({"tag:write", "grptags:write"})
     */
    private $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
