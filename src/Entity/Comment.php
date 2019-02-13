<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Internaut")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internaut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getInternaut(): ?Internaut
    {
        return $this->internaut;
    }

    public function setInternaut(?Internaut $internaut): self
    {
        $this->internaut = $internaut;

        return $this;
    }
}
