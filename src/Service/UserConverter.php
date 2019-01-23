<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Internaut;
use App\Entity\Vendor;

class UserConverter{

    function convertUser(User $user, $type)
    {
        if($user) {

            switch ($type) {

                case "internaut":
                    $newUser = new Internaut();
                    $newUser->setUsername($user->getUsername())
                        ->setEmail($user->getEmail())
                        ->setPassword($user->getPassword())
                        ->setSubDate(new \DateTime());
                    return $newUser;
                    break;

                case "vendor":
                    $newUser = new Vendor();
                    $newUser->setUsername($user->getUsername())
                        ->setEmail($user->getEmail())
                        ->setPassword($user->getPassword())
                        ->setSubDate(new \DateTime());
                    return $newUser;
                    break;

            }
        }else{
            return false;
        }
    }
}