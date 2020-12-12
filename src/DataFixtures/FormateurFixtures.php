<?php

namespace App\DataFixtures;




use Faker\Factory;
use App\Entity\Formateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormateurFixtures extends Fixture implements DependentFixtureInterface
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
                $formateur = new Formateur();
                
                $formateur->setNom($faker->name);
                $formateur->setUsername($faker->username);
                $formateur->setPrenom($faker->lastName);
                $formateur->setEmail($faker->email);
                $password = $this->encoder->encodePassword($formateur, 'courageous');
                $formateur->setPassword($password);
                $formateur->setProfil($this->getReference(ProfilFixtures::FORMATEUR_USER_REFERENCE));

                $manager->persist($formateur);

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