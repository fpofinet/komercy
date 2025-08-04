<?php

namespace App\Controller;

use App\Entity\Image;
use PDO;
use App\Entity\Product;
use App\Form\ProductForm;
use App\Service\FileUploaderService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ReferenceGeneratorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(ProductRepository $repo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repo->findAll(),
        ]);
    }

    #[Route('/product/add', name: 'add_product')]
    public function addProduct(FileUploaderService $fileUploader, Request $request,EntityManagerInterface $entityManager,ReferenceGeneratorService $referenceGenerator): Response
    {
        $product= new Product();
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setReference(reference: $referenceGenerator->generate());
            $product->setCreatedAt(new \DateTimeImmutable());
            $images = $form->get('images')->getData();
            foreach ($images as $file) {
                $name = $fileUploader->upload($file);
                $image = new Image();
                $image->setFilename($name);
                $image->setReference($referenceGenerator->generate());
                $image->setUploadedAt(new \DateTimeImmutable());
                $product->addImage($image);
            }
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product');
        }
        
        return $this->render('product/create.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'show_product')]
    public function showProduct(Product $product): Response
    {
        return $this->render('product/product.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/update', name: 'update_product')]
    public function updateProduct(Product $product,Request $request,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product');
        }
        
        return $this->render('product/update.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('product/{id}/delete', name: 'delete_product')]
    public function delete(Request $request, Product $product, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product');
    }
}


