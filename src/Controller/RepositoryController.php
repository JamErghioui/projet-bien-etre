<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RepositoryController extends AbstractController
{
    /**
     * @param CategoryRepository $catrepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function menu_categories(CategoryRepository $catrepo)
    {
        $categories = $catrepo->findAll();

        return $this->render('repository_templates/menu_categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
