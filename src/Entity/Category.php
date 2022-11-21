<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_city_read"})
     * @Groups({"api_post_list"})
     * @Groups({"api_post_read"})
     * @Groups({"api_user_read"})
     * @Groups({"api_category_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_city_read"})
     * @Groups({"api_post_list"})
     * @Groups({"api_post_read"})
     * @Groups({"api_user_read"})
     * @Groups({"api_category_list"})
     * @Assert\NotBlank(message="Merci de remplir ce champs")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="category")
     * @Groups({"api_category_list"})
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeCategory($this);
        }

        return $this;
    }
}
