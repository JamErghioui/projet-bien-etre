<?php

namespace App\Controller;

use App\Entity\Internaut;
use App\Entity\User;
use App\Entity\Vendor;
use App\Form\RegistrationInternautType;
use App\Form\RegistrationVendorType;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/registration/user", name="user_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function userRegistration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Crypting Password
            $crypted = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($crypted);

            // Set DateTime
            $user->setSubDate(new \DateTime());

            // Generate Token
            $token = bin2hex(random_bytes(32));
            $user->setConfirmToken($token);

            $manager->persist($user);
            $manager->flush();

            // Get mail from User
            $email = $user->getEmail();

            $message = (new \Swift_Message("Confirmation d'inscription"))
                ->setFrom('BienEtreTest@gmail.com')
                ->setTo($email)
                ->setBody('Message',
                    'text/plain'
                )
                ;

            $mailer->send($message);

            return $this->redirectToRoute('home');
        }

        return $this->render('user_templates/registration.html.twig',[
            'RegistrationUserForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/registration/internaut", name="internaut_registration")
     */
    public function internautRegistration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $internaut = new Internaut();

        $form = $this->createForm(RegistrationInternautType::class, $internaut);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){

            $crypted = $encoder->encodePassword($internaut, $internaut->getPassword());
            $internaut->setPassword($crypted);

            $internaut->setSubDate(new \DateTime());
            $manager->persist($internaut);
            $manager->flush();
        }

        return $this->render('user_templates/registration.html.twig', [
            "RegistrationInternautForm" => $form->createView()

        ]);
    }

    /**
     * @Route("/registration/vendor", name="vendor_registration")
     */
    public function vendorRegistration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $vendor = new Vendor();

        $form = $this->createForm(RegistrationVendorType::class, $vendor);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid()){
            $email = $vendor->getEmail();
            $vendor->setContactMail($email);

            $crypted = $encoder->encodePassword($vendor, $vendor->getPassword());
            $vendor->setPassword($crypted);

            $vendor->setSubDate(new \DateTime());
            $manager->persist($vendor);
            $manager->flush();

        }

        return $this->render('user_templates/registration.html.twig', [
            "RegistrationVendorForm" => $form->createView()
        ]);

    }
}
