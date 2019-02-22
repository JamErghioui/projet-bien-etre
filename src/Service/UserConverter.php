<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Internaut;
use App\Entity\Vendor;

class UserConverter{

    function convertUser(User $user, $type)
    {
        if($user && $type) {

            switch ($type) {

                case "internaut":
                    $newUser = new Internaut();

                    break;

                case "vendor":
                    $newUser = new Vendor();
                    $newUser->setRoles(['ROLE_VENDOR']);

                    break;

            }
            $newUser->setUsername($user->getUsername())
                ->setEmail($user->getEmail())
                ->setPassword($user->getPassword())
                ->setSubDate(new \DateTime());
            return $newUser;
        }else{
            return false;
        }
    }
}