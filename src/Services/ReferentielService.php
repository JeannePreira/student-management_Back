<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\GroupeCompetenceRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class ReferentielService
{
    public function __construct(UserPasswordEncoderInterface $encoder,SerializerInterface $serializer, GroupeCompetenceRepository $groupecompetenceRepo)
    {
        $this->serializer = $serializer;
        $this->encodePassword = $encoder;
        $this->groupecompetenceRepo = $groupecompetenceRepo;
    }

    public function addReferentiel(Request $request)
    {
        $data = $request->request->all();
        // $grpecompetence = $this->groupecompetenceRepo->findOneBy(['libelle' => $data['groupeCompetence']]);
        //  dd($data);
       

        $referentiel = $this->serializer->denormalize($data, "App\\Entity\Referentiel");
        $grpecompetence = explode(',' ,$data['groupeCompetence']);
        foreach($grpecompetence as $val){
            $referentiel->addGroupeCompetence($this->groupecompetenceRepo->findOneBy(['libelle' => $val]));
        }
        
        $referentiel->setDeleted(0);
        $programme=$request->files->get("programme");
        if ($programme) {
            $avatarConverti= fopen($programme->getRealPath(), "rb");
            $referentiel->setProgramme($avatarConverti);
    
        }

        return $referentiel;
    }  
}