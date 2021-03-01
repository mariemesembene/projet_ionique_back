<?php

namespace App\DataFixtures;


use App\Entity\Roles;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RolesFixture extends Fixture
{
    public const admin_system ='admin_system ';
    public const caissier = 'caissier';
    public const user_agence = 'user_agence ';
    public function load(ObjectManager $manager)
    {
        $admin_system= new Roles();
        $admin_system->setLibelle('admin_system');
        $manager->persist($admin_system);
        $this->addReference(self::admin_system, $admin_system);


        $caissier= new Roles();
        $caissier->setLibelle('caissier');
        $manager->persist($caissier);
        $this->addReference(self::caissier, $caissier);


        $user_agence= new Roles();
        $user_agence->setLibelle(' user_agence');
        $manager->persist($user_agence);
        $this->addReference(self::user_agence, $user_agence);

        $manager->flush();
    }
}
