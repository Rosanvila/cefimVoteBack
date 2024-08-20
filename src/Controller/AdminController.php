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

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin', methods: ['POST'])]
    public function index(Request $request, AdminRepository $adminRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $adminRepository->findOneBy(['name' => $data['name'], 'email' => $data['email']]);

        if ($user) {
            return new JsonResponse(['message' => 'Formateur déjà existant'], Response::HTTP_CONFLICT);
        }

        $user = new Admin();
        $user->setName($data['name']);
        $user->setPassword($data['password']);
        $user->setEmail($data['email']);
        $user->setSignature($data['signature']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['Nouvel administrateur' => $user->getName()]);
    }
}
