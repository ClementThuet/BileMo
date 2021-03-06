<?php

namespace App\DataFixtures;

use App\Entity\MobilePhone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BileMoFixtures extends Fixture
{
    private $passwordEncoder;
     
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $client = new Client();
            $client->setUsername('AdminSys'.$i.'@NotACompagny.com');
            $client->setPassword($this->passwordEncoder->encodePassword($client,'test'));
            $client->setFullname('Rebecca Front');
            $client->setEmail('AdminSys'.$i.'@NotACompagny.com');
            $manager->persist($client);
            
            for ($u = 0; $u < 5; $u++) {
                $user = new User();
                $user->setEmail('John'.$i.'Doe'.$u.'@gmail.com');
                $user->setPassword('test');
                $user->setRegisteredAt(new \DateTime('now'));
                $user->setClient($client);
                $user->setAdress($u.' Victory road');
                $user->setBirthDate(new \DateTime('26-12-1995'));
                $manager->persist($user);
            }
            $mobile = new MobilePhone();
            $mobile->setModelName('Universe U'.$i);
            $mobile->setModelReference('849'.$i.'4849'.$i.'418'.$i.'85');
            $mobile->setMemory('16');
            $mobile->setScreenDiagonalSize('5.2"');
            $mobile->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $mobile->setPrice('899');
            $mobile->setManufacturer('MoonCorp');
            $manager->persist($mobile);
        }
        $manager->flush();
    }
    
}