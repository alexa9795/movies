<?php

namespace App\Tests;

use App\Entity\Image;
use App\Entity\Movie;
use App\Entity\Video;
use App\Entity\VideoAlternative;
use App\Entity\ViewingWindow;
use App\Service\MovieService;
use Monolog\Test\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class MovieServiceTest extends TestCase
{
    public function testCreateMovieEntities()
    {
        $movies = [
            [
                "body" => 'movie body',
                "cardImages" =>
                    [
                        [
                            "url" => "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/11/29/Parental-Guidance-VPA.jpg",
                            "h" => 1004,
                            "w" => 768,
                        ]
                    ],
                "cast" => [
                    [
                        "name" => "Billy Crystal"
                    ],
                    [
                        "name" => "Bette Midler"
                    ]
                ],
                "cert" => "U",
                "class" => "Movie",
                "directors" => [
                      [
                          "name" => "Andy Fickman"
                      ]
                ],
                "duration" => 5940,
                "genres" => [ "Comedy", "Family" ],
                "headline" => "Parental Guidance",
                "id" => "8ad589013b496d9f013b4c0b684a4a5d",
                "keyArtImages" => [
                    [
                        "url" => "https://mgtechtest.blob.core.windows.net/images/unscaled/2012/11/29/Parental-Guidance-VPA.jpg",
                        "h" => 1004,
                        "w" => 768,
                    ]
                ],
                "lastUpdated" => "2013-07-15",
                "quote" => "an intriguing pairing of Bette Midler and Billy Crystal",
                "rating" => 3,
                "reviewAuthor" => "Tim Evans",
                "skyGoId" => "d1bf901693832410VgnVCM1000000b43150a____",
                "skyGoUrl" => "http://go.sky.com/vod/content/GOPCMOVIES/RSS/Movies/content/assetId/6ba3fb6afd03e310VgnVCM1000000b43150a________/videoId/d1bf901693832410VgnVCM1000000b43150a________/content/playSyndicate.do",
                "sum" => "66b14d5c58904900b13b404ae29eb7fe",
                "synopsis" =>  "When veteran baseball ...",
                "url" =>  "http://skymovies.sky.com/parental-guidance/review",
                "videos" =>
                    [
                        [
                            "title" => "Trailer - Parental Guidance",
                            "alternatives" =>
                                [
                                    [
                                        "quality" => "Low",
                                        "url" => "http://static.video.sky.com//skymovies/2012/11/44104/44104-270p_320K_H264.mp4"
                                    ],
                                    [
                                        "quality" => "Medium",
                                        "url"=> "http://static.video.sky.com//skymovies/2012/11/44104/44104-360p_800K_H264.mp4"
                                    ]
                                ],
                            "type" => "trailer",
                            "url" => "http://static.video.sky.com//skymovies/2012/11/44104/44104-360p_800K_H264.mp4"
                        ]
                    ],
                "viewingWindow" =>
                    [
                        "startDate" => "2013-12-27",
                        "wayToWatch" => "Sky Movies",
                        "endDate" => "2015-01-21"
                    ],
                "year" => "2012",
            ]
        ];

        $cardImage = (new Image())
            ->setUrl($movies[0]['cardImages'][0]['url'])
            ->setHeight($movies[0]['cardImages'][0]['h'])
            ->setWidth($movies[0]['cardImages'][0]['w'])
            ->setMovieIdCardImages($movies[0]['id']);

        $keyArtImage = (new Image())
            ->setUrl($movies[0]['keyArtImages'][0]['url'])
            ->setHeight($movies[0]['keyArtImages'][0]['h'])
            ->setWidth($movies[0]['keyArtImages'][0]['w'])
            ->setIdMovieKeyArtImages($movies[0]['id']);

        $videoAlternative = (new VideoAlternative())
            ->setUrl($movies[0]['videos'][0]['alternatives'][0]['url'])
            ->setQuality($movies[0]['videos'][0]['alternatives'][0]['quality'])
            ->setVideoId($movies[0]['id'] . '-' . 1);

        $video = (new Video())
            ->setUrl($movies[0]['videos'][0]['url'])
            ->setVideoAlternatives([$videoAlternative])
            ->setMovieId($movies[0]['id'])
            ->setTitle($movies[0]['videos'][0]['title'])
            ->setType($movies[0]['videos'][0]['type']);

        $viewingWindow = (new ViewingWindow())
            ->setStartDate($movies[0]['viewingWindow']['startDate'])
            ->setMovieId($movies[0]['id'])
            ->setEndDate($movies[0]['viewingWindow']['endDate'])
            ->setWayToWatch($movies[0]['viewingWindow']['wayToWatch']);

        $movieEntity = (new Movie())
            ->setId($movies[0]['id'])
            ->setBody($movies[0]['body'])
            ->setCardImages([$cardImage])
            ->setKeyArtImages([$keyArtImage])
            ->setVideos([$video])
            ->setViewingWindow($viewingWindow)
            ->setCast($movies[0]['cast'])
            ->setCert($movies[0]['cert'])
            ->setClass($movies[0]['class'])
            ->setDirectors($movies[0]['directors'])
            ->setDuration($movies[0]['duration'])
            ->setHeadline($movies[0]['headline'])
            ->setLastUpdated($movies[0]['lastUpdated'])
            ->setUrl($movies[0]['url'])
            ->setSum($movies[0]['sum'])
            ->setSynopsis($movies[0]['synopsis'])
            ->setYear($movies[0]['year']);

        /** @var MovieService|MockObject $movieServiceMock */
        $movieServiceMock = $this->getMockBuilder(MovieService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $movieServiceMock->method('createMovieEntities')
            ->with($movies)
            ->willReturn([$movieEntity]);

        $result = $movieServiceMock->createMovieEntities($movies);

        $this->assertInstanceOf(Movie::class,$result[0]);
        $this->assertClassHasAttribute('body',Movie::class);
        $this->assertClassHasAttribute('id',Movie::class);
        $this->assertClassHasAttribute('sum',Movie::class);
        $this->assertClassHasAttribute('synopsis',Movie::class);
        $this->assertClassHasAttribute('cert',Movie::class);
        $this->assertClassHasAttribute('class',Movie::class);
        $this->assertClassHasAttribute('cast',Movie::class);
        $this->assertClassHasAttribute('directors',Movie::class);
        $this->assertClassHasAttribute('url',Movie::class);
        $this->assertClassHasAttribute('year',Movie::class);
        $this->assertClassHasAttribute('headline',Movie::class);
        $this->assertClassHasAttribute('duration',Movie::class);
        $this->assertClassHasAttribute('cardImages',Movie::class);
        $this->assertClassHasAttribute('keyArtImages',Movie::class);
        $this->assertClassHasAttribute('videos',Movie::class);
        $this->assertClassHasAttribute('viewingWindow',Movie::class);
    }

    public function testAddDataToMovie()
    {
        $cardImage = (new Image())
            ->setUrl('imageUrl')
            ->setHeight(10)
            ->setWidth(10)
            ->setMovieIdCardImages('movieId1');

        $keyArtImage = (new Image())
            ->setUrl('imageUrl')
            ->setHeight(10)
            ->setWidth(14)
            ->setIdMovieKeyArtImages('movieId1');

        $videoAlternative = (new VideoAlternative())
            ->setUrl('video alternative url')
            ->setQuality('low')
            ->setVideoId('movieId1 - 1');

        $video = (new Video())
            ->setUrl('video url')
            ->setVideoAlternatives([$videoAlternative])
            ->setMovieId('movieId1')
            ->setTitle('trailer movie')
            ->setType('trailer');

        $viewingWindow = (new ViewingWindow())
            ->setStartDate('12-12-2000')
            ->setMovieId('movieId1')
            ->setEndDate('12-12-2001');

        $movieEntity = (new Movie())
            ->setId('movieId1')
            ->setBody('body')
            ->setCast(['actor1', 'actor2'])
            ->setCert('U')
            ->setClass(Movie::MOVIE_CLASS)
            ->setDirectors(['director1'])
            ->setDuration(3600)
            ->setHeadline('movie title')
            ->setLastUpdated('10-12-2000')
            ->setUrl('url')
            ->setSum('sum')
            ->setSynopsis('synopsis')
            ->setYear('2000');

        $movieWithAdditionalData = $movieEntity
            ->setCardImages([$cardImage])
            ->setKeyArtImages([$keyArtImage])
            ->setVideos([$video])
            ->setViewingWindow($viewingWindow);

        /** @var MovieService|MockObject $movieServiceMock */
        $movieServiceMock = $this->getMockBuilder(MovieService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $movieServiceMock->method('addDataToMovie')
            ->with($movieEntity)
            ->willReturn($movieWithAdditionalData);

        /** @var Movie $result */
        $result = $movieServiceMock->addDataToMovie($movieEntity);

        $this->assertEquals($result->getCardImages(), [$cardImage]);
        $this->assertEquals($result->getKeyArtImages(), [$keyArtImage]);
        $this->assertEquals($result->getVideos(), [$video]);
        $this->assertEquals($result->getViewingWindow(), $viewingWindow);
    }

}
