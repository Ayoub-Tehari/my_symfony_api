<?php

namespace App\Controller;

use App\Repository\SongRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Song;

class SongController extends AbstractController
{
    #[Route('/song', name: 'app_song')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SongController.php',
        ]);
    }
    #[Route('/api/song', name: 'song.getAll', methods: ['GET'])]
    public function getAllSongs(SongRepository $songRepository, serializerInterface $serializer): JsonResponse
    {
        $songs = $songRepository->getAllSongs();
        return $this->json([
            'songs' => $serializer->serialize($songs, 'json'),
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SongController.php',
        ]);
    }
    #[Route('/api/songs/{song_id}', name: 'song.get', methods: ['GET'])]
    public function getSong(Request $request, SongRepository $songRepository, serializerInterface $serializer, int $song_id): JsonResponse
    {
        $song = $songRepository->getOneSong($song_id);
        return $this->json([
            'song' => $serializer->serialize($song, 'json')
        ]);
    }
    #[Route('/api/songs', name: 'song.create', methods: ['POST'])]
    public function createSong(Request $request, serializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $song = $serializer->deserialize($request->getContent(), Song::class, 'json');
        $song->setCreatedAt(new \DateTime())->
            setUpdatedAt(new \DateTime())->
            setStatus("on");
        $entityManager->persist($song);
        $jsonSong = $serializer->serialize($song, "json");
        return $this->json([
            'affectedRow' => $request->getContent(),
            'ok' => 'OUI',
        ]);
    }

}
