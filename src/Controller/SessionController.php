<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SessionController extends AbstractController
{
    private SessionRepository $sessionRepository;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function __invoke(string $codesession): Response
    {
        $session = $this->sessionRepository->findOneBy(['codesession' => $codesession]);

        if (!$session) {
            return new JsonResponse(['message' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$session->getHeureDebut() || !$session->getHeureFin() || !$session->getDate()) {
            return new JsonResponse(['message' => 'Session data is incomplete'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'id' => $session->getId(),
            'codesession' => $session->getCodesession(),
            'promotion' => $session->getPromotion(),
            'heureDebut' => $session->getHeureDebut()->format('d-m-Y'),
            'heureFin' => $session->getHeureFin()->format('d-m-Y'),
            'date' => $session->getDate()->format('Y-m-d'),
        ]);
    }
}