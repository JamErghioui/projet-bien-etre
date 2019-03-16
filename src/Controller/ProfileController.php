<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Internaut;
use App\Entity\Stage;
use App\Entity\Vendor;
use App\Form\InternautType;
use App\Form\ProfilePictureType;
use App\Form\StageType;
use App\Form\VendorType;
use App\Repository\StageRepository;
use App\Service\Uploader;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            $form = $this->createForm(InternautType::class, $user, [
                'validation_groups' => ['internaut_profile']
            ]);
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
            $form = $this->createForm(VendorType::class, $user, [
                'validation_groups' => ['vendor_profile']
            ]);
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
     * @Route("/profile/image", name="profile_image")
     * @param Request $request
     * @param ObjectManager $manager
     * @param Uploader $uploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileImage(Request $request, ObjectManager $manager, Uploader $uploader)
    {

        $user = $this->getUser();

        $form = $this->createForm(ProfilePictureType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();

            if($uploadedFile){
                $newFilename = $uploader->uploadProfileImage($uploadedFile);

                if($user->getProfileImage()){ $profileImage = $user->getProfileImage(); }else{ $profileImage = new Image(); }

                $profileImage->setImageFilename($newFilename)
                            ->setImagePath('uploads/profile/'.$newFilename);
                $manager->persist($profileImage);

                $user->setProfileImage($profileImage);
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile_templates/profile_image.html.twig', [
            'form' => $form->createView()
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

            return $this->redirectToRoute('stages');
        }

        return $this->render('profile_templates/stages_create.html.twig', [
            'formStage' => $form->createView(),
            'vendor' => $vendor
        ]);
    }

    /**
     * @Route("/stage/edit/{id}", name="edit_stage")
     * @param Stage $stage
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editStage(Stage $stage, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($stage);
            $manager->flush();

            return $this->redirectToRoute('stages');
        }

        return $this->render('profile_templates/stages_edit.html.twig', [
            'formStage' => $form->createView(),
        ]);

    }

    /**
     * @Route("/stages/delete/{id}", name="delete_stage")
     * @param Stage $stage
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteStage(Stage $stage, ObjectManager $manager)
    {
        $manager->remove($stage);
        $manager->flush();

        return $this->redirectToRoute('stages');
    }
}
