<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Order;
use App\Entity\Products;
use App\Form\AttachFactureToOrderType;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoriesRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/catalogues', name: 'catalogues')]
    public function index(CategoriesRepository $categoriesRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();
            $category = new Categories();
            $category->setName($form->get('name')->getData());
            $category->setSlug($slugger->slug($form->get('name')->getData()));

            $entityManager->persist($category);
            $entityManager->flush();
        }

        return $this->render('admin/products/index.html.twig', [
            'catalogues' => $categoriesRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/catalogue/{slug}', name: 'catalogue')]
    public function details(Categories $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();

            $product = new Products();

            $product->setName($form->get('name')->getData());
            $product->setSlug($slugger->slug($form->get('name')->getData()));
            $product->setDescription($form->get('description')->getData());
            $product->setPrice($form->get('price')->getData());
            $product->setStock(10);
            $product->setCategories($category);

            /** @var UploadedFile $image */
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $product->addImage($newFilename);
            }

            $entityManager->persist($product);
            $entityManager->flush();
        }

        $products = $category->getProducts();

        return $this->render('admin/products/details.html.twig', [
            'category' => $category,
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commandes', name: 'commandes')]
    public function orders(OrderRepository $orders): Response
    {
        return $this->render('admin/orders/index.html.twig', [
            'controller_name' => 'Commandes des cliens',
            'orders' => $orders->findAll(),
        ]);
    }

    #[Route('/commandes/{id}', name: 'commandes_edit')]
    public function orderReceipt(Order $order, OrderRepository $orders, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(AttachFactureToOrderType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();

            /** @var UploadedFile $facture */
            $facture = $form->get('facture')->getData();

            if ($facture) {
                $originalFilename = pathinfo($facture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $facture->guessExtension();
                try {
                    $facture->move(
                        $this->getParameter('factures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $order->setFacture($newFilename);
                $entityManager->persist($order);
                $entityManager->flush();
            }

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('admin_commandes');
        }

        return $this->render('admin/orders/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
