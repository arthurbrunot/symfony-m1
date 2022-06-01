<?php

namespace App\Form\EventListener;

use App\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class RemoveCartItemListener.
 */
class RemoveCartItemListener implements EventSubscriberInterface
{
    /**
     * Removes items from the cart based on the data sent from the user.
     */
    public function postSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $form->getData();

        if (!$cart instanceof Order) {
            return;
        }

        // Removes items from the cart
        foreach ($form->get('items')->all() as $child) {
            if ($child->get('remove')->isClicked()) {
                $cart->removeItem($child->getData());
                break;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::POST_SUBMIT => 'postSubmit'];
    }
}
