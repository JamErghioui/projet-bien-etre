<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RepositoryController extends AbstractController
{
    /**
     * @param CategoryRepository $catrepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list_categories(CategoryRepository $catrepo)
    {
        $categories = $catrepo->findAll();

        return $this->render('repository_templates/list_categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param VendorRepository $vendorepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function last_vendors(VendorRepository $vendorepo)
    {
        $vendors = $vendorepo->findLast(3);

        return $this->render('repository_templates/last_vendors.html.twig',[
            'vendors' => $vendors
        ]);
    }
}
