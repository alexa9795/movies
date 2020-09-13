<?php

namespace App\Entity;

use App\Repository\ViewingWindowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ViewingWindowRepository::class)
 */
class ViewingWindow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     * @Assert\NotBlank(message = "Image url should not be blank.")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=20,  nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=50,  nullable=false)
     * @Assert\NotBlank(message = "Image url should not be blank.")
     */
    private $wayToWatch;

    /**
     * @ORM\Column(type="string", length=255,  nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $movieId;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate):self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getWayToWatch(): ?string
    {
        return $this->wayToWatch;
    }

    public function setWayToWatch(?string $wayToWatch)
    {
        $this->wayToWatch = $wayToWatch;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getMovieId(): string
    {
        return $this->movieId;
    }

    public function setMovieId(string $movieId): self
    {
        $this->movieId = $movieId;
        return $this;
    }
}
