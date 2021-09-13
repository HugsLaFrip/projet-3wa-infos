<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories/{slug}", name="categories")
     */
    public function index(Category $category): Response
    {
        return $this->render('categories/index.html.twig', [
            'category' => $category
        ]);
    }
}
