<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user->setConfirmToken($token);

            $manager->persist($user);
            $manager->flush();

            // Get Info from User
            $email = $user->getEmail();
            $username = $user->getUsername();
            $type = $request->request->get('user')['choose'];

            $url = "http://127.0.0.1:8000/confirmation/$type/$token";

            // Mail Builder
            $message = (new \Swift_Message("Confirmation d'inscription"))
                ->setSubject('Confirmation')
                ->setFrom(['BienEtreTest@gmail.com' => 'Bien-Être'])
                ->setTo([$email => $username])
                ->setBody("<h3>Bienvenue sur Bien-Être, $username</h3>
                                <p>Merci de confirmer votre inscription en cliquant sur le lien ci-dessous.</p>
                                <a href='$url'><button style='display: inline-block ;color: #ffffff; background: #2f4984; padding: 8px 16px; border-radius: 10px; text-shadow: 0 1px 1px #000000'>Confirmation</button></a><br>
                                <p style='text-align: center'><em style='font-size: small; color: grey'>Si vous n'êtes pas à l'origine de cette inscription, ne faites rien.</em></p><br>
                                <p style='text-align: center'><a href='#'><img src='https://res.cloudinary.com/dptzlt8ik/image/upload/v1547757926/Bien-Etre/logo.png' alt='logo'></a></p>",
                    'text/html'
                )
                ;
            $mailer->send($message);

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
