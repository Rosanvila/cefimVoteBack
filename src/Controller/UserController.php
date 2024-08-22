<?php
// src/Controller/UserController.php

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

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, SessionRepository $sessionRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
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

        if (!$nom || !$prenom) {
            return new JsonResponse(['message' => 'Nom ou prénom sont requis'], Response::HTTP_BAD_REQUEST);
        }

        if (strlen($nom) > 45 || strlen($prenom) > 45) {
            return new JsonResponse(['message' => 'Nom et prénom doivent être inférieurs à 45 caractères'], Response::HTTP_BAD_REQUEST);
        }


        $user = $this->userRepository->findOneBy(['nom' => $nom, 'prenom' => $prenom]);
        if ($user) {
            return new JsonResponse(['message' => 'Utilisateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setSignature(null);
        $user->setDelegue(null);
        $user->setSuppleant(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $response = new JsonResponse(['message' => 'Nouvel utilisateur créé', 'user' => $user->getNom() . ' ' . $user->getPrenom()], Response::HTTP_CREATED);
        $response->headers->set('Content-Type', 'application/ld+json');
        return $response;
    }
}