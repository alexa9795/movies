<?php

namespace App\Service;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Movie;
use App\Entity\Video;
use App\Entity\VideoAlternative;
use App\Entity\ViewingWindow;
use App\Repository\GalleryRepository;
use App\Repository\ImageRepository;
use App\Repository\MovieRepository;
use App\Repository\VideoAlternativeRepository;
use App\Repository\VideoRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovieService
{
    /** @var ManagerRegistry */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function createMovieEntities(array $movies): array
    {
        $movieEntities = [];

        foreach ($movies as $movie) {
            if ($this->movieExistsInDb($movie['id'])) {
                return [];
            }

            $cast = $this->getCast($movie['cast']);
            $directors = $this->getDirectors($movie['directors']);

            $movieEntity = (new Movie())
                ->setId($movie['id'])
                ->setBody($movie['body'])
                ->setCast($cast)
                ->setCert($movie['cert'])
                ->setClass($movie['class'])
                ->setDirectors($directors)
                ->setDuration($movie['duration'])
                ->setHeadline($movie['headline'])
                ->setLastUpdated($movie['lastUpdated'])
                ->setUrl($movie['url'])
                ->setSum($movie['sum'])
                ->setSynopsis($movie['synopsis'])
                ->setYear($movie['year']);

            $cardImages = $this->createCardImageEntities($movieEntity, $movie['cardImages'], $movie['id']);
            $keyArtImages = $this->createKeyArtImageEntities($movieEntity, $movie['keyArtImages'], $movie['id']);

            if (array_key_exists("genres", $movie)) {
                $movieEntity->setGenres($movie['genres']);
            }

            if (array_key_exists("quote", $movie)) {
                $movieEntity->setQuote($movie['quote']);
            }

            if (array_key_exists("rating", $movie)) {
                $movieEntity->setRating($movie['rating']);
            }

            if (array_key_exists("reviewAuthor", $movie)) {
                $movieEntity->setReviewAuthor($movie['reviewAuthor']);
            }

            if (array_key_exists("skyGoId", $movie)) {
                $movieEntity->setSkyGoId($movie['skyGoId']);
            }

            if (array_key_exists("skyGoUrl", $movie)) {
                $movieEntity->setSkyGoUrl($movie['skyGoUrl']);
            }

            if (array_key_exists("sgId", $movie)) {
                $movieEntity->setSgId($movie['sgId']);
            }

            if (array_key_exists("sgUrl", $movie)) {
                $movieEntity->setSgUrl($movie['sgUrl']);
            }

            $movieEntity->setCardImages($cardImages)
                ->setKeyArtImages($keyArtImages);

            if (array_key_exists('videos', $movie)) {
                $videos = $this->createVideoEntities($movieEntity, $movie['videos'], $movie['id']);

                $movieEntity->setVideos($videos);
            }

            if (array_key_exists("viewingWindow", $movie)) {
                $this->createViewingWindowEntity($movieEntity, $movie['viewingWindow'], $movie['id']);
            }

            if (array_key_exists("galleries", $movie)) {
                $galleries = $this->createGalleryEntities($movieEntity, $movie['galleries'], $movie['id']);

                $movieEntity->setGalleries($galleries);
            }

            $this->doctrine->getManager()->persist($movieEntity);

            $movieEntities[] = $movieEntity;
        }

        return $movieEntities;
    }

    public function addDataToMovie(Movie $movie): Movie
    {
        /** @var ImageRepository $imageRepository */
        $imageRepository = $this->doctrine->getRepository(Image::class);

        $cardImages = $imageRepository->findAllCardImagesForMovie($movie->getId());
        if(!empty($cardImages)) {
            $movie->setCardImages($cardImages);
        }

        $keyArtImages = $imageRepository->findAllKeyArtImagesForMovie($movie->getId());
        if(!empty($keyArtImages)) {
            $movie->setKeyArtImages($keyArtImages);
        }

        /** @var VideoRepository $videoRepository */
        $videoRepository = $this->doctrine->getRepository(Video::class);

        $videos = $videoRepository->findAllVideosForMovie($movie->getId());

        if (!empty($videos)) {
            /** @var Video $video */
            foreach ($videos as $video) {
                /** @var VideoAlternativeRepository $videoAlternativeRepository */
                $videoAlternativeRepository = $this->doctrine->getRepository(VideoAlternative::class);

                $videoAlternatives = $videoAlternativeRepository->findAllVideoAlternativesForVideo($video->getId());

                if(!empty($videoAlternatives)) {
                    $video->setVideoAlternatives($videoAlternatives);
                }
            }
        }

        if(!empty($videos)) {
            $movie->setVideos($videos);
        }

        /** @var GalleryRepository $galleryRepository */
        $galleryRepository = $this->doctrine->getRepository(Gallery::class);

        $galleries = $galleryRepository->findAllGalleriesForMovie($movie->getId());

        if(!empty($galleries)) {
            $movie->setGalleries($galleries);
        }

        /** @var ViewingWindow $viewingWindow */
        $viewingWindow = $this->doctrine
            ->getRepository(ViewingWindow::class)
            ->findOneBy(['movieId' => $movie->getId()]);

        if(!empty($viewingWindow)) {
            $movie->setViewingWindow($viewingWindow);
        }

        return $movie;
    }

    private function createCardImageEntities(Movie $movieEntity, array $cardImages, string $movieId): array
    {
        $cardImageEntities = [];

        foreach ($cardImages as $cardImage) {
            $cardImageEntity = (new Image())
                ->setUrl($cardImage['url'])
                ->setHeight($cardImage['h'])
                ->setWidth($cardImage['w'])
                ->setMovieIdCardImages($movieId);

            $this->doctrine->getManager()->persist($cardImageEntity);
            $cardImageEntities[] = $cardImageEntity;
        }
        return $cardImageEntities;
    }

    private function createKeyArtImageEntities(Movie $movieEntity, array $keyArtImages, string $movieId): array
    {
        $keyArtImageEntities = [];

        foreach ($keyArtImages as $keyArtImage) {
            $keyArtImageEntity = (new Image())
                ->setUrl($keyArtImage['url'])
                ->setHeight($keyArtImage['h'])
                ->setWidth($keyArtImage['w'])
                ->setIdMovieKeyArtImages($movieId);

            $this->doctrine->getManager()->persist($keyArtImageEntity);
            $keyArtImageEntities[] = $keyArtImageEntity;
        }
        return $keyArtImageEntities;
    }

    private function createVideoEntities(Movie $movieEntity, array $videos, string $movieId): array
    {
        $videoEntities = [];

        $videoId = 1;

        foreach ($videos as $video) {
            $videoEntity = (new Video())
                ->setId($movieId . '-' . $videoId)
                ->setUrl($video['url'])
                ->setMovieId($movieId)
                ->setTitle($video['title'])
                ->setType($video['type']);

            if (array_key_exists("thumbnailUrl",$video)) {
                $videoEntity->setThumbnailUrl($video['thumbnailUrl']);
            }

            if (array_key_exists("alternatives", $video)) {
                $videoAlternativesEntities = $this->createVideoAlternativesEntities($videoEntity, $video['alternatives']);

                $videoEntity->setVideoAlternatives($videoAlternativesEntities);
            }

            $this->doctrine->getManager()->persist($videoEntity);
            $videoEntities[] = $videoEntity;

            ++$videoId;
        }

        return $videoEntities;
    }

    private function createVideoAlternativesEntities(Video $videoEntity, array $alternatives): array
    {
        $videoAlternativeEntities = [];

        foreach ($alternatives as $alternative) {
            $videoAlternativeEntity = (new VideoAlternative())
                ->setUrl($alternative['url'])
                ->setQuality((int)$alternative['quality'])
                ->setVideoId($videoEntity->getId());

            $this->doctrine->getManager()->persist($videoAlternativeEntity);

            $videoAlternativeEntities[] = $videoAlternativeEntity;
        }

        return $videoAlternativeEntities;
    }

    private function createGalleryEntities(Movie $movieEntity, array $galleries, string $movieId): array
    {
        $galleryEntities = [];

        foreach ($galleries as $gallery) {
            $galleryEntity = (new Gallery())
                ->setUrl($gallery['url'])
                ->setTitle($gallery['title'])
                ->setMovieId($movieId);

            if (array_key_exists("thumbnailUrl",$gallery)) {
                $galleryEntity->setThumbnailUrl($gallery['thumbnailUrl']);
            }

            $this->doctrine->getManager()->persist($galleryEntity);
            $galleryEntities[] = $galleryEntity;
        }

        return $galleryEntities;
    }

    private function createViewingWindowEntity(Movie $movieEntity, array $viewingWindow, string $movieId): ViewingWindow
    {
        $viewingWindowEntity = (new ViewingWindow())
            ->setStartDate($viewingWindow['startDate'])
            ->setWayToWatch($viewingWindow['wayToWatch'])
            ->setMovieId($movieId);

        if (array_key_exists("endDate", $viewingWindow)) {
            $viewingWindowEntity->setEndDate($viewingWindow['endDate']);
        }

        if (array_key_exists("title", $viewingWindow)) {
            $viewingWindowEntity->setTitle($viewingWindow['title']);
        }

        $this->doctrine->getManager()->persist($viewingWindowEntity);

        return $viewingWindowEntity;
    }

    private function getCast(array $cast): array
    {
        return array_column($cast, 'name');
    }

    private function getDirectors(array $directors): array
    {
        return array_column($directors, 'name');
    }

    private function movieExistsInDb(string $movieId): bool
    {
        /** @var MovieRepository $movieRepo */
        $movieRepo = $this->doctrine->getManager()->getRepository(Movie::class);

        $movieInDb = $movieRepo->findOneBy(['id' => $movieId]);

        if (!empty($movieInDb)) {
            return true;
        }

        return false;
    }
}
