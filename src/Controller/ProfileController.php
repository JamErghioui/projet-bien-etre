<?php

namespace App\Controller;

use App\Entity\Internaut;
use App\Entity\Stage;
use App\Entity\Vendor;
use App\Form\InternautType;
use App\Form\StageType;
use App\Form\VendorType;
use App\Repository\StageRepository;
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
    public function editUser(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

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
            'class' => $class
        ]);
    }

    /**
     * @Route("/stages", name="stages")
     * @param StageRepository $stageRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stage(StageRepository $stageRepository)
    {
        $vendor = $this->getUser()->getId();

        $stages = $stageRepository->findBy([
            'vendor' => $vendor
        ]);

        return $this->render('profile_templates/stages.html.twig',[
            'stages' => $stages
        ]);
    }

    /**
     * @Route("/stages/create", name="stages_create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stageCreate(Request $request, ObjectManager $manager)
    {
        $vendor = $this->getUser();
        $stage = new Stage();

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $stage->setVendor($vendor);

            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile_templates/stages_create.html.twig', [
            'formStage' => $form->createView(),
            'vendor' => $vendor
        ]);
    }
}
