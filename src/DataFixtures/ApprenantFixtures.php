<?php

namespace App\DataFixtures;




use Faker\Factory;

use App\Entity\Apprenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ApprenantFixtures extends Fixture implements DependentFixtureInterface  
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(PersistenceObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

            for ($i = 0; $i < 4; $i++) {
                $apprenant = new Apprenant();
                
                $apprenant->setNom($faker->name);
                $apprenant->setUsername($faker->username);
                $apprenant->setPrenom($faker->lastName);
                $apprenant->setEmail($faker->email);
                $apprenant->setTelephone($faker->phoneNumber);
                $password = $this->encoder->encodePassword($apprenant, 'courageous');
                $apprenant->setPassword($password);
                $apprenant->setProfil($this->getReference(ProfilFixtures::APPRENANT_USER_REFERENCE));

                $manager->persist($apprenant);

            }
            $manager->flush();

    }


    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
            UserFixtures::class
        );
    }
}