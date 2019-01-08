<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DistrictRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchForm(Request $request, VendorRepository $vendor, CategoryRepository $category, DistrictRepository $district)
    {
        dump($request->query);
        $categories = $category->findAll();
        $districts = $district->findAll();

        $get_name = $request->query->get('name');
        $get_category = $request->query->get('category');
        $get_district = $request->query->get('district');

        $query = ['name'=>$get_name, 'category'=>$get_category, 'district'=>$get_district];

        $vendors = $vendor->findSearch($get_name,$get_category,$get_district);

        return $this->render('search_templates/search.html.twig',[
            "vendors" => $vendors,
            "categories" => $categories,
            "districts" => $districts,
            "query" => $query
            ]);
    }
}
