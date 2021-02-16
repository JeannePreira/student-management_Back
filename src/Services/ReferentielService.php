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
        $grpecompetence = $this->groupecompetenceRepo->findOneBy(['libelle' => $data["groupeCompretence"]]);
       
        unset($data['groupeCompetence']);
        
        $referentiel = $this->serializer->denormalize($data, "App\\Entity\Referentiel");
        // $grpecompetence -> explode($data['groupeCompetences']);
            $referentiel->addGroupeCompetence($grpecompetence);

        // $grpecompetence ->explode(',' ,$data['groupeCompetence']);
        // foreach($grpecompetence as $val){
        //     $referentiel->addGroupeCompetence($this->groupecompetenceRepo->findOneBy(['libelle' => $val]));
        // }
        
        $referentiel->setDeleted(0);
        $programme=$request->files->get("programme");
        if ($programme) {
            $avatarConverti= fopen($programme->getRealPath(), "rb");
            $referentiel->setProgramme($avatarConverti);
    
        }

        return $referentiel;
    }





    // public function putUser(Request $request,string $fileName = null){
    //     $raw =$request->getContent();

    // //    dd($raw);
    //     $delimiteur = "multipart/form-data; boundary=";
    //     $boundary= "--" . explode($delimiteur,$request->headers->get("content-type"))[1];
    //     $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
    //     // dd($elements);
    //     $elementsTab = explode("\r\n\r\n",$elements);
    //     // dd($elementsTab);
    //     $data =[];
    //     for ($i=0;isset($elementsTab[$i+1]);$i+=2){
    //         // dd($elementsTab[$i+1]);
    //         $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
    //         // dd($key);
    //         if (strchr($key,$fileName)){
    //             $stream =fopen('php://memory','r+');
    //             // dd($stream);
    //             fwrite($stream,$elementsTab[$i +1]);
    //             rewind($stream);
    //             $data[$fileName] = $stream;
    //             // dd($data);
    //         }
    //             $val=$elementsTab[$i+1];
    //             $val = str_replace(["\r\n", "--"],'',($elementsTab[$i+1]));
    //             //dd($val);
    //             $data[$key] = $val;
    //            // dd($data[$key]);
           
    //     }
    //         //dd($data);
    //         // dd($data["profil"]);
    //         if (isset($data["profil"])) {
    //             $prof=$this->profilRepo->findOneBy(['libelle'=>$data["profil"]]);
    //             $data["profil"] = $prof;
    //         }
       
    //     // dd($prof);
    //     return $data;

    // }
}