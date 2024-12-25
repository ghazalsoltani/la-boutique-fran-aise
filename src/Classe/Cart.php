<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
        // Inject the RequestStack to handle session operations
    }

    public function add($product)
    {
        // Retrieve the current cart from the session or initialize a new one
        $cart = $this->requestStack->getSession()->get('cart');

        // Check if the product is already in the cart
        if (isset($cart[$product->getId()])) {
            // Increment the quantity of the existing product
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {
            // Add the product to the cart with a quantity of 1
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1,
            ];
        }

        // Save the updated cart back to the session
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function remove()
    {
        // Remove the entire cart from the session
        return $this->requestStack->getSession()->remove('cart');
    }

    public function getCart()
    {
        // Retrieve and return the cart from the session
        return $this->requestStack->getSession()->get('cart');
    }
}