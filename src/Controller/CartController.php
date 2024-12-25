<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        // Render the cart view with the current cart contents
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository): Response
    {
        // Retrieve the product by its ID
        $product = $productRepository->findOneById($id);

        // Add the product to the cart
        $cart->add($product);

        // Flash a success message to inform the user
        $this->addFlash(
            'success',
            'Produit correctement ajouté à votre panier.'
        );

        // Redirect back to the product page
        return $this->redirectToRoute('app_product', [
            'slug' => $product->getSlug()
        ]);
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {
        // Clear the cart by removing it from the session
        $cart->remove();

        // Redirect to the homepage
        return $this->redirectToRoute('app_home');
    }
}