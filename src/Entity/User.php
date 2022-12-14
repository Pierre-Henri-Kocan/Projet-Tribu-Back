<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_city_read"})
     * @Groups({"api_post_list"})
     * @Groups({"api_user_read"})
     * @Groups({"api_category_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"api_user_read"})
     * @Assert\Email
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_city_read"})
     * @Groups({"api_post_list"})
     * @Groups({"api_post_read"})
     * @Groups({"api_user_read"})
     * @Groups({"api_category_list"})
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_city_read"})
     * @Groups({"api_post_list"})
     * @Groups({"api_post_read"})
     * @Groups({"api_user_read"})
     * @Groups({"api_category_list"})
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $lastname;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"api_user_read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     * @Groups({"api_user_read"})
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     * @Groups({"api_user_read"})
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="users")
     * @Groups({"api_user_read"})
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $city;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->roles = array('ROLE_USER');
    }

    public function __toString() 
    {
        return $this->firstname . $this->lastname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function getRolesName() :string
    {
        $arrayRole = $this->getRoles();
        return implode($arrayRole);

    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
