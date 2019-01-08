<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "vendor" = "Vendor"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\District")
     * @ORM\JoinColumn(nullable=false)
     */
    private $district;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZipCode")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zipcode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locality;

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

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getZipcode(): ?ZipCode
    {
        return $this->zipcode;
    }

    public function setZipcode(?ZipCode $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }
}
