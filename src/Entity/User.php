<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin","apprenant" = "Apprenant","formateur"="Formateur","cm"="CM", "user"="User"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *       attributes = {
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "security_message" = "Accès interdit!!"
 *      },
 *      collectionOperations = {
 *          "GET" = {
 *              "path": "/admin/users",
 *              "normalization_context" ={"groups"={"users:read"}}
 *          },
 *          "adUser" = {
 *              "method": "POST",
 *              "path" = "/admin/users",
 *              "deserialize" = false
 *           }
 *      },
 *      itemOperations = {
 *          "getBy"={
 *              "method" = "get",
 *              "path" = "/admin/users/{id}",
 *              "normalization_context" ={"groups"={"users:read"}}
 *           },
 *          "putUser" = {
 *               "method"= "PUT",
 *              "path" = "/admin/users/{id}",
 *              "deserialize" = false,
 *              "route_name"="putUser"
 *          },
 *          "deleteUser" = {
 *               "method"= "DELETE",
 *              "path" = "/admin/users/{id}",
 *              "deserialize" = false
 *          }
 *      }
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"deleted": "exact"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"group:write", "groupe:read", "groupeApp:read", "groupPut:write", "brief:write","briefs:read", "users:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"group:write", "groupe:read", "groupeApp:read", "groupPut:write", "briefs:read", "users:read"})
     * @Assert\NotBlank
     */
    private $email;

   
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"promoFormateur:write", "promoFormateur:write", "promoApp:write", "groupPut:write","users:read"})
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promoFormateur:write", "promoApp:write", "promoFormateur:write", "groupPut:write", "users:read"})
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promoFormateur:write", "promoApp:write", "promoFormateur:write", "groupPut:write", "users:read"})
     * @Assert\NotBlank(message = "prenom obligatoire")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupPut:write", "users:read"})
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"users:read"})
     * @Assert\NotBlank
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"users:read"})
     * 
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"users:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $deleted = 0;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
        $this->profils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatar()
    {
        if ($this->avatar){
            $avatar=stream_get_contents($this->avatar);
            return base64_encode($avatar);
        }
        return null;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDeleted(): ?int
    {
        return $this->deleted = 0;
    }

    public function setDeleted(int $deleted): self
    {
        $this->deleted = $deleted;
        

        return $this;
    }



}
