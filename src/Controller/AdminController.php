<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/admin', name: 'app_admin', methods: ['POST'])]
    public function index(Request $request, AdminRepository $adminRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $adminRepository->findOneBy(['name' => $data['name'], 'email' => $data['email']]);

        if ($user) {
            return new JsonResponse(['message' => 'Formateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new Admin();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setSignature($data['signature']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['Nouvel administrateur' => $user->getName()]);
    }
}