<?php

namespace App\DataFixtures;



use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;


class ProfilFixtures extends Fixture  
{
    public const ADMIN_USER_REFERENCE = 'ADMIN';
    public const APPRENANT_USER_REFERENCE = 'APPRENANT';
    public const FORMATEUR_USER_REFERENCE = 'FORMATEUR';
    public const CM_USER_REFERENCE = 'CM';


    public function load(PersistenceObjectManager $manager)
    {

        $libelles = ["APPRENANT", "ADMIN", "FORMATEUR", "CM"];

        for($i = 0; $i<4; $i++){

            $profil = new Profil();
            $profil->setLibelle($libelles[$i]);
            $profil->setStatut(false);

            if($libelles[$i]==="APPRENANT"){
                $this->setReference(self::APPRENANT_USER_REFERENCE,$profil);
            }
            else if($libelles[$i]==="ADMIN"){
                $this->setReference(self::ADMIN_USER_REFERENCE,$profil);
            }
            else if($libelles[$i]==="CM"){
                $this->setReference(self::CM_USER_REFERENCE,$profil);
            } else if($libelles[$i]==="FORMATEUR"){
                $this->setReference(self::FORMATEUR_USER_REFERENCE,$profil);
            }   
            $manager->persist($profil);
        }
        
        $manager->flush();
    }

}