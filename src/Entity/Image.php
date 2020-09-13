<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Image url should not be blank.")
     */
    private $url;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message = "Image height should not be blank.")
     */
    private $height;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message = "Image width should not be blank.")
     */
    private $width;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movieIdCardImages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $movieIdKeyArtImages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getMovieIdCardImages(): ?string
    {
        return $this->movieIdCardImages;
    }

    public function setMovieIdCardImages(?string $movieIdCardImages): self
    {
        $this->movieIdCardImages = $movieIdCardImages;

        return $this;
    }

    public function getIdMovieKeyArtImages(): ?string
    {
        return $this->movieIdKeyArtImages;
    }

    public function setIdMovieKeyArtImages(?string $movieIdKeyArtImages): self
    {
        $this->movieIdKeyArtImages = $movieIdKeyArtImages;

        return $this;
    }
}
