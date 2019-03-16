<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Internaut;
use App\Entity\Vendor;
use App\Form\AdminInternautType;
use App\Form\AdminVendorType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\InternautRepository;
use App\Repository\VendorRepository;
use App\Service\Uploader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function settings(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/settings.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category", name="admin_category")
     * @Route("/admin/category/{id}", name="admin_category_edit")
     * @param Category|null $category
     * @param Request $request
     * @param ObjectManager $manager
     * @param Uploader $uploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function category(Category $category = null, Request $request, ObjectManager $manager, Uploader $uploader)
    {
        if(!$category){
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();

            if($uploadedFile){
                $newFilename = $uploader->uploadBannerImage($uploadedFile);

                if($category->getBannerImage()){ $bannerImage = $category->getBannerImage(); }else{ $bannerImage = new Image(); }

                $bannerImage->setImageFilename($newFilename)
                    ->setImagePath('uploads/banner/'.$newFilename);
                $manager->persist($bannerImage);

                $category->setBannerImage($bannerImage);
            }

            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('admin_settings');
        }

        return $this->render('admin/admin_category.html.twig', [
            'form' => $form->createView(),
            'edit' => $category->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/category/highlight/{id}", name="admin_highlight", methods={"POST"})
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function highlight(Category $category, CategoryRepository $categoryRepository, ObjectManager $manager)
    {
        $current = $categoryRepository->findOneBy(
            ['highlight' => true ]
        );

        $current->setHighlight(false);
        $category->setHighlight(true);

        $manager->persist($current);
        $manager->persist($category);

        $manager->flush();

        return $this->redirectToRoute('admin_settings');
    }

    /**
     * @Route("/admin/user/{type}/{id}", name="admin_detail")
     * @param $type
     * @param $id
     * @param Request $request
     * @param ObjectManager $manager
     * @param InternautRepository $internautRepository
     * @param VendorRepository $vendorRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userDetail($type, $id, Request $request, ObjectManager $manager, InternautRepository $internautRepository, VendorRepository $vendorRepository)
    {
        $user = [];
        $view = [];
        $form = [];

        if($type === 'internaut'){
            $user = $internautRepository->find($id);
        }elseif($type === 'vendor'){
            $user = $vendorRepository->find($id);
        }

        if($user instanceof Internaut){
            $form = $this->createForm(AdminInternautType::class, $user);
            $view = $form->createView();
        }elseif($user instanceof Vendor){
            $form = $this->createForm(AdminVendorType::class, $user);
            $view = $form->createView();
        }

        if($form){
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                if($user->getBanned()){
                    $user->setBanned(false);

                }else{
                    $user->setBanned(true);
                    if($type === 'vendor'){
                        $user->setIsVisible(false);
                    }
                }

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('admin_detail', ['type' => $type, 'id' => $id]);
            }
        }

        return $this->render('admin/detail.html.twig', [
            'type' => $type,
            'user' => $user,
            'form' => $view
        ]);
    }
}
