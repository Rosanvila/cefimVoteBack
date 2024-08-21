<?php

namespace App\Controller;

use App\Entity\User;
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

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;

        if (!$nom || !$prenom) {
            return new JsonResponse(['message' => 'Nom et prénom sont requis'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->findOneBy(['nom' => $nom, 'prenom' => $prenom]);

        if ($user) {
            return new JsonResponse(['message' => 'Utilisateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);

        // Set default values for other fields if necessary
        $user->setSignature(null);
        $user->setDelegue(false);
        $user->setSuppleant(false);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Nouvel utilisateur créé', 'user' => $user->getNom() . ' ' . $user->getPrenom()], Response::HTTP_CREATED);
    }
}