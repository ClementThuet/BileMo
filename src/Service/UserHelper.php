<?php

namespace App\Service;

use App\Entity\User;

class UserHelper {
    
    public function createUser($user)
    {
        $userSubmited = new User();
        $userSubmited->setEmail($user->getEmail());
        $userSubmited->setPassword($user->getPassword());
        $userSubmited->setAdress($user->getAdress());
        $userSubmited->setBirthDate($user->getBirthDate());
        
        
        return $userSubmited;
    }
}
