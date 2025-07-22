<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieForm;
use App\Form\CategorieTypeForm;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $repo): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $repo->findAll(),
        ]);
    }

    #[Route('/categorie/add', name: 'app_categorie_add')]
    public function addCategorie(Request $request,EntityManagerInterface $entityManager): Response
    {
        $categorie= new Categorie();
        $form = $this->createForm(CategorieForm::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setReference("REF");
            $categorie->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('app_categorie');
        }
        
        return $this->render('categorie/create.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/categorie/{id}', name: 'app_categorie_show')]
    public function showCategorie(Categorie $categorie): Response
    {
        return $this->render('categorie/categorie.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/categorie/{id}/update', name: 'app_categorie_update')]
    public function updateCategorie(Categorie $categorie,Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieForm::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('app_categorie');
        }
        
        return $this->render('categorie/update.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('categorie/{id}/delete', name: 'app_categorie_delete')]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
            $em->remove($categorie);
            $em->flush();
        }

        return $this->redirectToRoute('app_categorie');
    }
}
