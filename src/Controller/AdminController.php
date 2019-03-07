<?php

namespace App\Controller;

use App\Repository\InternautRepository;
use App\Repository\VendorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param InternautRepository $internautRepository
     * @param VendorRepository $vendorRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboard(InternautRepository $internautRepository, VendorRepository $vendorRepository)
    {
        $internauts = $internautRepository->findLast(5);
        $vendors = $vendorRepository->findLast(4);

        return $this->render('admin/admin.html.twig',[
            'internauts' => $internauts,
            'vendors' => $vendors
        ]);
    }

    /**
     * @Route("/admin/internauts", name="admin_internauts")
     * @param Request $request
     * @param InternautRepository $internautRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function internauts(Request $request,InternautRepository $internautRepository)
    {
        $get_value= $request->query->get('value_internaut');
        $internauts = $internautRepository->findUsernameMail($get_value);

        return $this->render('admin/internauts.html.twig', [
            'internauts' => $internauts
        ]);
    }

    /**
     * @Route("/admin/vendors", name="admin_vendors")
     * @param Request $request
     * @param VendorRepository $vendorRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function vendors(Request $request, VendorRepository $vendorRepository)
    {
        $get_value= $request->query->get('value_vendor');
        $vendors= $vendorRepository->findUsernameMail($get_value);

        return $this->render('admin/vendors.html.twig',[
            'vendors' => $vendors
        ]);
    }

    /**
     * @Route("/admin/settings", name="admin_settings")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function settings()
    {
        return $this->render('admin/settings.html.twig');
    }
}
