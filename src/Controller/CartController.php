<?php

namespace App\Controller;

use App\Form\CartType;
use App\Form\ConfirmOrderType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CartController
 * @package App\Controller
 */
class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]

    public function index(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        $confirmForm = $this->createForm(ConfirmOrderType::class, $cart);
        $confirmForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart');
        }

        if($confirmForm->isSubmitted() && $confirmForm->isValid()) {
            $cart->setStatus("confirmed");
            $cartManager->save($cart);

            return $this->redirectToRoute('profile_orders');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
            'confirmForm' => $confirmForm->createView()
        ]);
    }
}