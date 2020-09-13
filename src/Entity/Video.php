<?php


namespace App\Entity;

use App\Entity\VideoAlternative;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Video url should not be blank.")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnailUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Video title should not be blank.")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Video type should not be blank.")
     */
    private $type;

    /**
     * @var VideoAlternative[]|ArrayCollection
     */
    private $videoAlternatives;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $movieId;


    public function __construct()
    {
        $this->videoAlternatives = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnailUrl;
    }

    public function setThumbnailUrl(?string $thumbnailUrl): self
    {
        $this->thumbnailUrl = $thumbnailUrl;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getMovieId(): ?string
    {
        return $this->movieId;
    }

    public function setMovieId(?string $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    public function getVideoAlternatives(): array
    {
        return $this->videoAlternatives;
    }

    public function setVideoAlternatives(array $videoAlternatives): self
    {
        $this->videoAlternatives = $videoAlternatives;

        return $this;
    }
}
