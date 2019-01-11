<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Vendor;
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
        $highlight = $catrepo->findOneBy([
            'Highlight' => true
        ]);

        return $this->render('services_templates/index.html.twig',[
            'category' => $highlight
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function category(Category $category)
    {
        return $this->render('services_templates/category.html.twig',[
            'category' => $category
        ]);
    }

    /**
     * @Route("/vendor/{id}", name="vendor")
     * @param Vendor $vendor
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function vendor(Vendor $vendor)
    {
        return $this->render('services_templates/vendor.html.twig',[
            'vendor' => $vendor
        ]);
    }
}