<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SessionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, SessionRepository $sessionRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function __invoke(Request $request): Response
    {
        $contentType = $request->headers->get('Content-Type');
        if ($contentType !== 'application/ld+json' && $contentType !== 'application/json') {
            return new JsonResponse(['message' => 'Unsupported content type'], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $signature = $data['signature'] ?? null;
        $usersSessionUri = $data['UsersSession'] ?? null;

        if (!$nom || !$prenom || !$usersSessionUri) {
            return new JsonResponse(['message' => 'Nom, prénom et UsersSession sont requis'], Response::HTTP_BAD_REQUEST);
        }

        if (strlen($nom) > 45 || strlen($prenom) > 45) {
            return new JsonResponse(['message' => 'Nom et prénom doivent être inférieurs à 45 caractères'], Response::HTTP_BAD_REQUEST);
        }

        // Extract codesession from UsersSession URI
        $uriParts = explode('/', $usersSessionUri);
        $codesession = end($uriParts);

        $session = $this->sessionRepository->findOneBy(['codesession' => $codesession]);
        if (!$session) {
            return new JsonResponse(['message' => 'Session non trouvée'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findOneBy(['nom' => $nom, 'prenom' => $prenom]);
        if ($user) {
            return new JsonResponse(['message' => 'Utilisateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setSignature($signature);
        $user->setDelegue(null);
        $user->setSuppleant(null);
        $user->setUsersSession($session);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $response = new JsonResponse(['message' => 'Nouvel utilisateur créé', 'user' => $user->getNom() . ' ' . $user->getPrenom()], Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/ld+json');
        return $response;
    }
}