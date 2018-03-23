<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $posts_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $posts_msg;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $posts_created_at;

    public function getId()
    {
        return $this->id;
    }


    public function getPostsEmail(): ?string
    {
        return $this->posts_email;
    }

    public function setPostsEmail(?string $posts_email): self
    {
        $this->posts_email = $posts_email;

        return $this;
    }

    public function getPostsMsg(): ?string
    {
        return $this->posts_msg;
    }

    public function setPostsMsg(?string $posts_msg): self
    {
        $this->posts_msg = $posts_msg;

        return $this;
    }

    public function getPostsCreatedAt(): ?\DateTimeInterface
    {
        return $this->posts_created_at;
    }

    public function setPostsCreatedAt(\DateTimeInterface $posts_created_at): self
    {
        $this->posts_created_at = $posts_created_at;

        return $this;
    }
}
