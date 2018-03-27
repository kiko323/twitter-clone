<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 */
class Posts {

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;


  /**
   * @ORM\Column(name="posts_email", type="string", length=255, nullable=true)
   */
  public $postsEmail;

  /**
   * @ORM\Column(name="posts_msg", type="string", length=255, nullable=true)
   */
  public $postsMsg;

  /**
   * @ORM\Column(name="posts_created_at", type="datetime")
   */
  public $PostsCreatedAt;

  public function getId () {
    return $this->id;
  }

  public function getPostsEmail (): ?string {
    return $this->postsEmail;
  }

  public function setPostsEmail (?string $postsEmail): self {
    $this->postsEmail = $postsEmail;

    return $this;
  }

  public function getPostsMsg (): ?string {
    return $this->postsMsg;
  }

  public function setPostsMsg (?string $postsMsg): self {
    $this->postsMsg = $postsMsg;

    return $this;
  }

  public function getPostsCreatedAt (): ?\DateTimeInterface {
    return $this->PostsCreatedAt;
  }

  public function setPostsCreatedAt (\DateTimeInterface $PostsCreatedAt): self {
    $this->PostsCreatedAt = $PostsCreatedAt;

    return $this;
  }
}
