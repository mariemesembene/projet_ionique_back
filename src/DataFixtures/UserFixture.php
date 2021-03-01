<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\DataFixtures\RolesFixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture

{
    public function __construct(UserPasswordEncoderInterface $pwdEncoder)
    {
        $this->pwdEncoder= $pwdEncoder;
      
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        
                $user = new User();
                $user
                    ->setNom($faker->lastName)
                    ->setPrenom($faker->firstName)
                    ->setEmail($faker->email)
                    ->setTelephone('781700647')
                    ->setStatut(false)
                    ->setPassword($this->pwdEncoder->encodePassword($user,"test"));
                $user->setRolesEntity($this->getReference(RolesFixture::admin_system));
                $manager->persist($user);
        
      
            $user = new User();
            $user
                ->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setEmail($faker->email)
                ->setTelephone('781700646')
                ->setStatut(false)
                ->setPassword($this->pwdEncoder->encodePassword($user,"test"));
            $user->setRolesEntity($this->getReference(RolesFixture::caissier));
            $manager->persist($user);
 
   
        $user = new User();
        $user
            ->setNom($faker->lastName)
            ->setPrenom($faker->firstName)
            ->setEmail($faker->email)
            ->setTelephone('781700645')
            ->setStatut(false)
            ->setPassword($this->pwdEncoder->encodePassword($user,"test"));
        $user->setRolesEntity($this->getReference(RolesFixture::user_agence));
        $manager->persist($user);




        $manager->flush();
    }
}
