<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 19/02/2019
 * Time: 12:05
 */

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface as Generator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Generator
     */
    private $urlGenerator;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param Generator $urlGenerator
     */
    public function __construct(\Swift_Mailer $mailer, Generator $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    public function sendConfirmation(User $user, $type)
    {
        $email = $user->getEmail();
        $username = $user->getUsername();
        $link = $this->urlGenerator->generate("user_confirmation", ['type'=>$type,'confirmToken'=>$user->getConfirmToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new \Swift_Message("Confirmation d'inscription"))
            ->setSubject('Confirmation')
            ->setFrom(['BienEtreTest@gmail.com' => 'Bien-Être'])
            ->setTo([$email => $username])
            ->setBody("<h4>Bienvenue sur Bien-Être, $username</h4>
                            <p>Merci de confirmer votre inscription en cliquant sur le lien ci-dessous.</p>
                            <a href='$link'><button style='display: inline-block ;color: #ffffff; background: #2f4984; padding: 8px 16px; border-radius: 10px; text-shadow: 0 1px 1px #000000'>Confirmation</button></a><br>
                            ", 'text/html')
        ;
        $this->mailer->send($message);
    }
}