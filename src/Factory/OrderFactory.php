<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Products;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Security\Core\Security;

/**
 * Class OrderFactory.
 */
class OrderFactory
{
    public function __construct(
        Security $security,
    ) {
        $this->security = $security;
    }

    /**
     * Creates an order.
     *
     * @return Order
     */
    #[NoReturn]
 public function create(): Order
 {
     $user = $this->security->getUser();
     $order = new Order();
     $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ->setAttachedUser($user);

     return $order;
 }

    public function completeOrder(Order $order): Order
    {
        $order->setStatus('completed');

        return $order;
    }

    /**
     * Creates an item for a product.
     */
    public function createItem(Products $product): OrderItem
    {
        $item = new OrderItem();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }
}
