<?php

namespace App\Controller;

use App\Entity\Internaut;
use App\Entity\Vendor;
use App\Form\InternautType;
use App\Form\VendorType;
use App\Repository\ZipCodeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editUser(Request $request, ObjectManager $manager, ZipCodeRepository $zipcode)
    {
        $user = $this->getUser();
        $zipcodes = $zipcode->findAll();

        if(get_class($user) == Internaut::class)
        {
            $class = 'Internaut';
            $form = $this->createForm(InternautType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('home');
            }
        }
        elseif (get_class($user) == Vendor::class)
        {
            $class = 'Vendor';
            $form = $this->createForm(VendorType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                if(
                    $user->getUsername() &&
                    $user->getContactMail() &&
                    $user->getPhone() &&
                    $user->getVat() &&
                    $user->getWebsite() &&
                    $user->getDoorNumber() &&
                    $user->getStreet() &&
                    $user->getDistrict() &&
                    $user->getZipCode() &&
                    $user->getLocality() &&
                    $user->getCategory()
                ){
                    $user->setIsVisible(true);
                }else{
                    $user->setIsVisible(false);
                }

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('home');
            }
        }

        return $this->render('profile_templates/profile.html.twig', [
            'form' => $form->createView(),
            'class' => $class,
            'zipcodes' => $zipcodes
        ]);
    }
}
