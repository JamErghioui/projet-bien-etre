<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "vendor" = "Vendor", "internaut" = "Internaut"})
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $banned = false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(groups={"registration"})
     */
    protected $email;

    /**
     * @ORM\column(type="array")
     */
    protected $roles = ['ROLE_USER'];

    /**
     * @ORM\Column(type="date")
     */
    protected $sub_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="7", minMessage="Minimum 7 caractères", groups={"registration"})
     */
    protected $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Password et Confirmation ne sont pas identiques", groups={"registration"})
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Minimum 7 caractères", groups={"registration", "vendor_profile", "internaut_profile"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $confirmToken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     */
    protected $profileImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubDate(): ?\DateTimeInterface
    {
        return $this->sub_date;
    }

    public function setSubDate(\DateTimeInterface $sub_date): self
    {
        $this->sub_date = $sub_date;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(?string $confirmToken): self
    {
        $this->confirmToken = $confirmToken;

        return $this;
    }

    public function getProfileImage(): ?Image
    {
        return $this->profileImage;
    }



    public function setProfileImage(?Image $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }
}
