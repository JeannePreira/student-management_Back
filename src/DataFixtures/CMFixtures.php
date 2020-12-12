<?php

namespace App\DataFixtures;





use App\Entity\CM;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CMFixtures extends Fixture implements DependentFixtureInterface
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
                $cm = new CM();
                
                $cm->setNom($faker->name);
                $cm->setUsername($faker->username);
                $cm->setPrenom($faker->lastName);
                $cm->setEmail($faker->email);
                $password = $this->encoder->encodePassword($cm, 'courageous');
                $cm->setPassword($password);
                $cm->setProfil($this->getReference(ProfilFixtures::CM_USER_REFERENCE));

                $manager->persist($cm);

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