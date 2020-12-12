<?php

namespace App\DataFixtures;


use App\Entity\CM;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
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
                $user = new User();
                
                $user->setNom($faker->name);
                $user->setUsername($faker->username);
                $user->setPrenom($faker->lastName);
                $user->setEmail($faker->email);
                $password = $this->encoder->encodePassword($user, 'courageous');
                $user->setPassword($password);
                $user->setProfil($this->getReference(ProfilFixtures::ADMIN_USER_REFERENCE));
                // $this->addReference($i, $user);

                $manager->persist($user);

            }
            $manager->flush();

    }


    public function getDependencies()
    {
        return array(

            ProfilFixtures::class,
        );
    }
}