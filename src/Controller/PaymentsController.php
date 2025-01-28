<?php

namespace App\Controller;


use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentsController extends AbstractController
{
    #[Route('/commande/paiment', name: 'app_payments')]
    public function index(): Response
    {
        Stripe::setApiKey('sk_test_51Qm07kRwhbE0S47KOfwQTyRPeo8CLS2lAyoqEHwP1ykoLZwzAFgPj2zDSE7oowWQgJubfQJyF1V6IgZJXEUu6FcZ00kbDHIhto');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $checkout_session = Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => '1500',
                    'product_data' => [
                        'name' =>'produit de test'
                    ]
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        return $this->redirect($checkout_session->url);
    }
}
