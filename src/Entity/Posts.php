<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;


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
   * @ORM\Column(name="posts_msg", type="string", length=255, nullable=true)
   */
  public $postsMsg;

  /**
   * @ORM\Column(name="posts_created_at", type="datetime")
   */
  public $PostsCreatedAt;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
   * @ORM\JoinColumn(name="userId", nullable=true)
   */
  private $userId;

  public function getId () {
    return $this->id;
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

  public function getUserId (): ?User {
    return $this->userId;
  }

  public function setUserId (?User $userId) {
    $this->userId = $userId;
  }
}
