<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $door_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sub_conf;

    /**
     * @ORM\Column(type="date")
     */
    private $sub_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Postal", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postal_code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locality_name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Town", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $town_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoorNumber(): ?string
    {
        return $this->door_number;
    }

    public function setDoorNumber(string $door_number): self
    {
        $this->door_number = $door_number;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

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

    public function getSubConf(): ?bool
    {
        return $this->sub_conf;
    }

    public function setSubConf(bool $sub_conf): self
    {
        $this->sub_conf = $sub_conf;

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

    public function getUserType(): ?string
    {
        return $this->user_type;
    }

    public function setUserType(string $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getPostalCode(): ?Postal
    {
        return $this->postal_code;
    }

    public function setPostalCode(?Postal $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getLocalityName(): ?Locality
    {
        return $this->locality_name;
    }

    public function setLocalityName(?Locality $locality_name): self
    {
        $this->locality_name = $locality_name;

        return $this;
    }

    public function getTownName(): ?Town
    {
        return $this->town_name;
    }

    public function setTownName(?Town $town_name): self
    {
        $this->town_name = $town_name;

        return $this;
    }
}
