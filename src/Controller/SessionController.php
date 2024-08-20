<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    #[Route('/api/session/{codesession}', name: 'app_session', methods: ['GET'])]
    public function index(string $codesession): Response
    {
        $session = $this->sessionRepository->findOneBy(['codesession' => $codesession]);

        if (!$session) {
            return new JsonResponse(['message' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $session->getId(),
            'codesession' => $session->getCodesession(),
            'promotion' => $session->getPromotion(),
            'heureDebut' => $session->getHeureDebut()->format('Y-m-d H:i:s'),
            'heureFin' => $session->getHeureFin()->format('Y-m-d H:i:s'),
            'date' => $session->getDate()->format('Y-m-d'),
        ]);
    }
}