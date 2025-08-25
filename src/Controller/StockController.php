<?php

namespace App\Controller;

use App\Entity\StockMovement;
use App\Form\StockMovementForm;
use App\Service\StockService;
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
    public function addProduct(Request $request, EntityManagerInterface $em,StockService $stockService): Response
    {
        $entree = new StockMovement();

        $form = $this->createForm(StockMovementForm::class, $entree);
        if ($form->isSubmitted() && $form->isValid()) {
            $entree->setType("ENTREE");
            $stockService->createStockMovement($entree);
            $em->persist($entree);
            $em->flush();
            return $this->redirectToRoute('stock');
        }
        return $this->render('stock/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/stock/withdraw-product', name: 'withdraw_product_stock')]
    public function withdrawProduct(Request $request, EntityManagerInterface $em,StockService $stockService): Response
    {
        $sortie = new StockMovement();

        $form = $this->createForm(StockMovementForm::class, $sortie);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setType("SORTIE");
            $stockService->createStockMovement($sortie);

            $em->persist($sortie);
            $em->flush();

            $this->addFlash('success', 'correct');

            return $this->redirectToRoute('stock');
        }
        return $this->render('stock/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
