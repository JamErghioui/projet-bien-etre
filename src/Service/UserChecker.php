<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 24/03/2019
 * Time: 22:07
 */

namespace App\Service;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    /**
     * Checks the user account before authentication.
     *
     * @param UserInterface $user
     */
    public function checkPreAuth(UserInterface $user)
    {
        if($user->getBanned()){
            throw new CustomUserMessageAuthenticationException('You are banned');
        }
    }

    /**
     * Checks the user account after authentication.
     *
     * @param UserInterface $user
     */
    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}