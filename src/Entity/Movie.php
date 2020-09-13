<?php


namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Movie
{
    const MOVIE_CLASS = 'Movie';

    const COMEDY_GENRE = 'Comedy';
    const FAMILY_GENRE = 'Family';
    const CLASSICS_GENRE = 'Classics';
    const MYSTERY_GENRE = 'Mystery';
    const ROMANCE_GENRE = 'Romance';
    const THRILLER_GENRE = 'Thriller';
    const ACTION_AND_ADVENTURE_GENRE = 'Action & Adventure';
    const FANTASY_GENRE = 'Sci-fi/Fantasy';
    const DRAMA_GENRE = 'Drama';
    const WORLD_CINEMA_GENRE = 'World Cinema';
    const HORROR_GENRE = 'Horror';
    const ANIMATION_GENRE = 'Animation';

    const GENRES = [
        self::ACTION_AND_ADVENTURE_GENRE,
        self::ANIMATION_GENRE,
        self::CLASSICS_GENRE,
        self::COMEDY_GENRE,
        self::FAMILY_GENRE,
        self::FANTASY_GENRE,
        self::MYSTERY_GENRE,
        self::ROMANCE_GENRE,
        self::THRILLER_GENRE,
        self::DRAMA_GENRE,
        self::WORLD_CINEMA_GENRE,
        self::HORROR_GENRE
    ];

    const PG_CERT = 'PG';
    const U_CERT = 'U';
    const CERT_12 = '12';
    const CERT_15 = '15';
    const CERT_18 = '18';

    const CERTS = [
        self::CERT_12,
        self::CERT_15,
        self::CERT_18,
        self::PG_CERT,
        self::U_CERT
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message = "Body should not be blank.")
     */
    private $body;

    /**
     * @ORM\Column(type="array", nullable=false)
     * @Assert\NotBlank(message = "Cast should not be blank.")
     */
    private $cast;

    /**
     * @ORM\Column(type="string", options={"values":Movie::CERTS}, nullable=false)
     * @Assert\NotBlank(message = "Cert should not be blank.")
     */
    private $cert;

    /**
     * @Assert\NotBlank(message = "Class should not be blank.")
     * @ORM\Column(type="string", options={"values":Movie::MOVIE_CLASS}, nullable=false)
     */
    private $class;

    /**
     * @ORM\Column(type="array", nullable=false)
     * @Assert\NotBlank(message = "Directors should not be blank.")
     */
    private $directors;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank(message = "Duration should not be blank.")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", options={"values":Movie::GENRES}, nullable=true)
     */
    private $genres;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message = "Headline should not be blank.")
     */
    private $headline;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank(message = "Last updated should not be blank.")
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quote;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $reviewAuthor;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $skyGoId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $skyGoUrl;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank(message = "Sum should not be blank.")
     */
    private $sum;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank(message = "Synopsis should not be blank.")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message = "Url should not be blank.")
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     * @Assert\NotBlank(message = "Year should not be blank.")
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sgId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sgUrl;

    /**
     * @var Image[]|ArrayCollection
     */
    private $cardImages;

    /**
     * @var Image[]|ArrayCollection
     */
    private $keyArtImages;

    /**
     * @var Video[]|ArrayCollection
     */
    private $videos;

    /**
     * @var Gallery[]|ArrayCollection
     */
    private $galleries;

    /** @var ViewingWindow */
    private $viewingWindow;
    
    public function __construct()
    {
        $this->cardImages = new ArrayCollection();
        $this->keyArtImages = new ArrayCollection();
        $this->cardImages = new ArrayCollection();
        $this->cardImages = new ArrayCollection();
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

    /**
     * @return mixed|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Movie
     */
    public function setBody($body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getCast(): ?array
    {
        if($this->cast){
            return json_decode($this->cast);
        }

        return null;
    }

    public function setCast(array $cast): self
    {
        $this->cast = json_encode($cast);
        return $this;
    }

    public function getCert(): string
    {
        return $this->cert;
    }

    public function setCert(string $cert): self
    {
        $this->cert = $cert;
        return $this;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        if ($class !== self::MOVIE_CLASS) {
            throw new \Exception(sprintf('This class (%s) is not allowed.', $class));
        }

        $this->class = $class;
        return $this;
    }

    public function getDirectors(): ?array
    {
        if($this->directors){
            return json_decode($this->directors);
        }
        return null;
    }

    public function setDirectors(array $directors): self
    {
        $this->directors = json_encode($directors);
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getGenres(): ?array
    {
        if($this->genres){
            return json_decode($this->genres);
        }
        return null;
    }

    public function setGenres(?array $genres): self
    {
        $this->genres = json_encode($genres);
        return $this;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function setHeadline(string $headline): self
    {
        $this->headline = $headline;
        return $this;
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(string $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(?string $quote): self
    {
        $this->quote = $quote;
        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getReviewAuthor(): ?string
    {
        return $this->reviewAuthor;
    }

    public function setReviewAuthor(?string $reviewAuthor): self
    {
        $this->reviewAuthor = $reviewAuthor;
        return $this;
    }

    public function getSkyGoId(): ?string
    {
        return $this->skyGoId;
    }

    public function setSkyGoId(?string $skyGoId): self
    {
        $this->skyGoId = $skyGoId;
        return $this;
    }

    public function getSkyGoUrl(): ?string
    {
        return $this->skyGoUrl;
    }

    public function setSkyGoUrl(?string $skyGoUrl): self
    {
        $this->skyGoUrl = $skyGoUrl;
        return $this;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    public function setSum(string $sum): self
    {
        $this->sum = $sum;
        return $this;
    }

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;
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

    public function getYear(): string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getSgId(): ?string
    {
        return $this->sgId;
    }

    public function setSgId(string $sgId): self
    {
        $this->sgId = $sgId;
        return $this;
    }

    public function getSgUrl(): ?string
    {
        return $this->sgUrl;
    }

    public function setSgUrl(?string $sgUrl): self
    {
        $this->sgUrl = $sgUrl;
        return $this;
    }

    public function getCardImages(): array
    {
        return $this->cardImages;
    }

    public function setCardImages(array $cardImages): self
    {
        $this->cardImages = $cardImages;

        return $this;
    }

    public function getKeyArtImages(): array
    {
        return $this->keyArtImages;
    }

    public function setKeyArtImages(array $keyArtImages): self
    {
        $this->keyArtImages = $keyArtImages;

        return $this;
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function setVideos(array $videos): self
    {
        $this->videos = $videos;

        return $this;
    }

    public function getGalleries(): ?array
    {
        return $this->galleries;
    }

    public function setGalleries(?array $galleries): self
    {
        $this->galleries = $galleries;

        return $this;
    }

    public function getViewingWindow(): ?ViewingWindow
    {
        return $this->viewingWindow;
    }

    public function setViewingWindow(?ViewingWindow $viewingWindow): self
    {
        $this->viewingWindow = $viewingWindow;

        return $this;
    }
}
