<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Mailer;
use App\Service\UserConverter;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/registration", name="user_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userRegistration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, Mailer $mailer)
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
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user->setConfirmToken($token);

            $manager->persist($user);
            $manager->flush();

            // Get Type from User
            $type = $request->request->get('user')['choose'];

            // Mail Builder
            $mailer->sendConfirmation($user,$type);

            return $this->redirectToRoute('user_login');
        }

        return $this->render('user_templates/registration.html.twig',[
            'RegistrationUserForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="user_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userLogin()
    {
        return $this->render('user_templates/login.html.twig');
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function userLogout()
    {

    }

    /**
     * @Route("/confirmation/{type}/{confirmToken}", name="user_confirmation")
     * @param User $user
     * @param $type
     * @param ObjectManager $manager
     * @param UserConverter $converter
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailConfirmation(User $user, $type, UserConverter $converter, ObjectManager $manager)
    {

        if($user){
            $newUser = $converter->convertUser($user, $type);

            $manager->persist($newUser);
            $manager->remove($user);
            $manager->flush();
        }

        return $this->render('user_templates/login.html.twig');
    }
}
