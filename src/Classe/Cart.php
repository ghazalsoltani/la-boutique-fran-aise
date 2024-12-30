<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
        // Inject the RequestStack to handle session operations
    }

    /*
     * add()
     * Function to add a product to the shopping cart.
     */
    public function add($product)
    {
        // Retrieve the current cart from the session or initialize a new one
        $cart = $this->getCart();
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

    /*
     * decrease()
     * Function to remove the full quantity of a product from the shopping cart.
     */
    public function decrease($id)
    {
        $cart = $this->getCart();

        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        } else {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
     * fullQuantity()
     * Function to return the total number of products in the shopping cart.
     */
    public function fullQuantity()
    {
        $cart = $this->getCart();
        $quantity = 0;

        if (!isset($cart)) {
            return $quantity;
        }
        foreach ($cart as $product) {
            $quantity = $quantity + $product['qty'];

        }
        return $quantity;
    }

    /*
     * getTotalWt()
     * Function to return the total price of the shopping cart.
     */
    public function getTotalWt()
    {
        $cart = $this->getCart();
        $price = 0;

        if (!isset($cart)) {
            return $price;
        }

        {
            foreach ($cart as $product) {
                $price = $price + ($product['object']->getPriceWt() * $product['qty']);
            }
        }

        return $price;
    }

    /*
     * remove()
     * Function to completely clear the shopping cart.
     */
    public function remove()
    {
        // Remove the entire cart from the session
        return $this->getCart();
    }

    /*
     * getCart()
     * Function to return the shopping cart.
     */
    public function getCart()
    {
        // Retrieve and return the cart from the session
        return $this->requestStack->getSession()->get('cart');
    }
}