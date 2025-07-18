<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/save', name: 'app_test')]
    public function save(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $doctrine): Response
    {
        // ... e.g. get the user data from a registration form
        $user = new User();
        $user->setUsername("fika");
        $plaintextPassword ="123456";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $doctrine->persist($user);
        $doctrine->flush();
        return new Response("created");
    }
}
