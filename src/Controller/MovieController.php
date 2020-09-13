<?php


namespace App\Controller;


use App\Entity\Image;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Service\MovieService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry as Registry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Registry $registry, MovieService $movieService): Response
    {
        $moviesJson = file_get_contents('movies.json');
        $movies = $this->getJson($moviesJson);

        try {
            $movieService->createMovieEntities($movies);

            $entityManager = $registry->getManager();

            $entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request, MovieRepository $movieRepository): Response
    {
        /** @var Movie[] $movies */
        $movies = $movieRepository->findAll();

        return $this->render('list.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/list/{id}", name="show")
     */
    public function showMovieDetails(MovieRepository $movieRepository, MovieService $movieService, string $id): Response
    {
        $movie = $movieRepository->findOneBy(['id' => $id]);

        $movieWithAdditionalInfo = $movieService->addDataToMovie($movie);

        return $this->render('movie.html.twig', ['movie' => $movieWithAdditionalInfo]);
    }

    private function getJson(string $json)
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpException(400, 'Invalid json');
        }

        return $data;
    }
}
