<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Products;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OrderFactory
 * @package App\Factory
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
    #[NoReturn] public function create(): Order
    {
        $user = $this->security->getUser();
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setUserId($user->id);

        return $order;
    }

    public function completeOrder(Order $order): Order
    {
        $order->setStatus("completed");

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Products $product
     *
     * @return OrderItem
     */
    public function createItem(Products $product): OrderItem
    {
        $item = new OrderItem();
        $item->setProduct($product);
        $item->setQuantity(1);

        return $item;
    }
}