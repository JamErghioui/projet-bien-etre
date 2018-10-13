<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $catrepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryRepository $catrepo)
    {
        $categories = $catrepo->findAll();
        return $this->render('services/index.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     * @param CategoryRepository $catrepo
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function category(CategoryRepository $catrepo, Category $category)
    {
        $categories = $catrepo->findAll();
        return $this->render('services/category.html.twig',[
            'category' => $category,
            'categories' => $categories
        ]);
    }
}
