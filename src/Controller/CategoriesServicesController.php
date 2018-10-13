<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesServicesController extends AbstractController
{
    /**
     * @Route("/categories/services", name="categories_services")
     * @param CategoryRepository $catrepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categories( CategoryRepository $catrepo)
    {
        $categories = $catrepo->findAll();

        return $this->render('categories_services/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
