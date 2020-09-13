<?php


namespace App\Entity;

use App\Repository\VideoAlternativeRepository;
use App\Entity\Video;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VideoAlternativeRepository::class)
 */
class VideoAlternative
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Video alternative should not be blank.")
     */
    private $url;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message = "Quality should not be blank.")
     */
    private $quality;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
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

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): self
    {
        $this->quality = $quality;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }
}
