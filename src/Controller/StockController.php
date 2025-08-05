<?php

namespace App\Controller;

use App\Entity\StockMovement;
use App\Form\StockMovementForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class StockController extends AbstractController
{
    #[Route('/stock', name: 'stock')]
    public function index(): Response
    {
        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    #[Route('/stock/add-product', name: 'add_product_stock')]
    public function addProduct(Request $request, EntityManagerInterface $em): Response
    {
        $entree = new StockMovement();

        $form = $this->createForm(StockMovementForm::class, $entree);
        if ($form->isSubmitted() && $form->isValid()) {
            // Ici, $entree contient toutes les lignes (produit + quantité)
            // Doctrine va persister tout automatiquement si cascade persist est configuré

            $em->persist($entree);
            $em->flush();

            $this->addFlash('success', 'correct');

            return $this->redirectToRoute('stock');
        }
        return $this->render('stock/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
