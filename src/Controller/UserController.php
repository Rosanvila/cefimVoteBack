<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'app_user', methods: ['POST'])]
    public function index(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->findOneBy(['nom' => $data['nom'], 'prenom' => $data['prenom']]);

        if ($user) {
            return new JsonResponse(['message' => 'Utilisateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setSignature($data['signature']);
        $user->setDelegue($data['delegue']);
        $user->setSuppleant($data['suppleant']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['Nouvel utilisateur' => $user->getNom() . ' ' . $user->getPrenom()]);
    }
}


