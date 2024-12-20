<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    //Define the route with a dynamic parameter {slug}
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $categoryRepository): Response
    {
        //Use the CategoryRepository to find the category with the matching slug
        $category = $categoryRepository->findOneBySlug($slug);

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
