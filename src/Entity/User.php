<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, errorPath="email", message="This E-mail address is already in use.")
 * @UniqueEntity(fields={"username"}, errorPath="username", message="This username is already in use.")
 *
 * @ORM\Table(name="User")
 */
class User implements AdvancedUserInterface, \Serializable {

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=25, nullable=true, unique=true)
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=64, nullable=true)
   */
  private $password;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, unique=true)
   */
  private $email;

  /**
   * @ORM\Column(name="isActive", type="boolean", nullable=true)
   */
  private $isActive;

  private $plainPassword;

  /**
   * @ORM\OneToMany(targetEntity="App\Entity\Posts", mappedBy="User")
   */
  private $posts;

  public function __construct () {
    $this->isActive = true;
    $this->posts = new ArrayCollection();
    // for now not needed:
    // $this->salt = md5(uniqid('', true));
  }

  public function getSalt () {
    //getSalt not needed as bcrypt is used for encoding
    return null;
  }

  public function isAccountNonExpired () {
    return true;
  }

  public function isAccountNonLocked () {
    return true;
  }

  public function isCredentialsNonExpired () {
    return true;
  }

  public function isEnabled () {
    return $this->isActive;
  }


  public function eraseCredentials () {
  }

  /** @see \Serializable::serialize() */
  public function serialize () {
    return serialize(array(
      $this->id,
      $this->username,
      $this->password,
      $this->isActive
      // see section on salt below
      // $this->salt,
    ));
  }

  /** @see \Serializable::unserialize() */
  public function unserialize ($serialized) {
    list (
      $this->id,
      $this->username,
      $this->password,
      $this->isActive

      ) = unserialize($serialized);
  }

  public function getRoles () {
    return array('ROLE_USER');
  }

  public function getId () {
    return $this->id;
  }

  public function getUsername (): ?string {
    return $this->username;
  }

  public function setUsername (?string $username): self {
    $this->username = $username;

    return $this;
  }

  public function getPassword (): ?string {
    return $this->password;
  }

  public function setPassword (?string $password): self {
    $this->password = $password;

    return $this;
  }

  public function getEmail (): ?string {
    return $this->email;
  }

  public function setEmail (?string $email): self {
    $this->email = $email;

    return $this;
  }

  public function getIsActive (): ?bool {
    return $this->isActive;
  }

  public function setIsActive (?bool $isActive): self {
    $this->isActive = $isActive;

    return $this;
  }

  public function getPlainPassword (): ?string {
    return $this->plainPassword;
  }

  public function setPlainPassword (?string $plainPassword): self {
    $this->plainPassword = $plainPassword;

    return $this;
  }

  /**
   * @return Collection|Posts[]
   */
  public function getPosts () {
    return $this->posts;
  }
}
