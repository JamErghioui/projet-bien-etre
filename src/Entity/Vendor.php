<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VendorRepository")
 */
class Vendor extends User
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $contact_mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $vat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $door_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $street;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="vendors")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="vendor", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\District")
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $district;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZipCode")
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $zipcode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality")
     * @Assert\NotBlank(groups={"vendor_profile"})
     */
    private $locality;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_visible = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="vendor", orphanRemoval=true)
     */
    private $stage;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->stage = new ArrayCollection();
    }


    public function getContactMail(): ?string
    {
        return $this->contact_mail;
    }

    public function setContactMail(string $contact_mail): self
    {
        $this->contact_mail = $contact_mail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getVat(): ?string
    {
        return $this->vat;
    }

    public function setVat(string $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
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

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVendor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getVendor() === $this) {
                $comment->setVendor(null);
            }
        }

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

    public function getIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $sub_conf): self
    {
        $this->is_visible = $sub_conf;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stage->contains($stage)) {
            $this->stage[] = $stage;
            $stage->setVendor($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stage->contains($stage)) {
            $this->stage->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getVendor() === $this) {
                $stage->setVendor(null);
            }
        }

        return $this;
    }
}
