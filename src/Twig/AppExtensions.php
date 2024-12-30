<?php

namespace App\Twig;

use App\Classe\Cart;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{
    private $categoryRepository;
    private $cart;
    //Constructor for dependency injection of CategoryRepository
    public function __construct(CategoryRepository $categoryRepository, Cart $cart)
    {
        //store the injected repository in the private property
        $this->categoryRepository = $categoryRepository;
        $this->cart = $cart;
    }
    /**
     * @return TwigFilter[]
     * Define custom twig filters
     *
     * This method is used to register custom filters that can be used in Twig templates.
     */
    public function getFilters()
    {
        return [
            // Define a filter named "price" that calls the "formatPrice" method
            new TwigFilter('price', [$this, 'formatPrice'])
        ];
    }

    /**
     * @return string
     * Custom filter to format prices
     *
     * This method formats a number as a price with:
     * 2 decimal places
     * a comma (,) as the decimal separator
     * a euro € symbol
     */
    public function formatPrice($number)
    {
        //format the number with 2 decimal places, a comma as a decimal separator and no thousand separator
        return number_format($number, '2', ','). ' €';
    }
    /**
     * Define global variables accessible in Twig templates.
     *
     * This method allows defining variables that are globally available in all Twig templates.
     */
    public function getGlobals(): array
    {
        return [
            // Define a global variable "allCategories" containing all categories from the repository
            'allCategories' => $this->categoryRepository->findAll(),
            'fullCartQuantity' => $this->cart->fullQuantity()
        ];
    }
}