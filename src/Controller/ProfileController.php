<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Profil de l\'utilisateur',
        ]);
    }

    #[Route('/commandes', name: 'orders')]
    public function orders(OrderRepository $order): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
            'orders' => $order->findByUserId($this->getUser()->getId()),
        ]);
    }
}
