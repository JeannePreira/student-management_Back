<?php


namespace App\Services;

use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserService
{
    public function __construct(\Swift_Mailer $mailer,UserPasswordEncoderInterface $encoder,
                                SerializerInterface $serializer, ProfilRepository $profilRepo,
                                ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->Swift_Mailer = $mailer;
        $this->encodePassword = $encoder;
        $this->profilRepo = $profilRepo;
        $this->validator = $validator;
    }

    public function givePassword($p="123"){
        return $p;
    }

    public function sendMail($user){
        $mail=$user->getEmail();
        $password=$user->getPassword();
        $msg=(new\Swift_Message('noveau mot de passe'))
            ->setFrom('jeano@gmail.com')
            ->setTo($mail)
            ->setBody(
                'utiliser le mot de passe suggéré'.$password
            );

            $this->Swift_Mailer->send($msg);
    }




    public function addUser(Request $request, $profil=null)
    {
        $data = $request->request->all();
        $profil = $this->profilRepo->findOneBy(['libelle' => $data["profil"]]);
        ;

        unset($data['profil']);

        $user = $this->serializer->denormalize($data, "App\Entity\\".$profil->getLibelle(), true);
        $user->setProfil($profil);
        // dd($user);
        $user->setDeleted(0);
        $avatar=$request->files->get("avatar");
        if ($avatar) {
            $avatarConverti= fopen($avatar->getRealPath(), "rb");
            $user->setAvatar($avatarConverti);
    
        }
            $plainPassword = $this->givePassword();
            $user->setPassword($plainPassword);
            $encoded = $this->encodePassword->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);


            return $user;
    }





    public function putUser(Request $request,string $fileName = null){
        $raw =$request->getContent();

    //    dd($raw);
        $delimiteur = "multipart/form-data; boundary=";
        $boundary= "--" . explode($delimiteur,$request->headers->get("content-type"))[1];
        $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
        // dd($elements);
        $elementsTab = explode("\r\n\r\n",$elements);
        // dd($elementsTab);
        $data =[];
        for ($i=0;isset($elementsTab[$i+1]);$i+=2){
            // dd($elementsTab[$i+1]);
            $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
            // dd($key);
            if (strchr($key,$fileName)){
                $stream =fopen('php://memory','r+');
                // dd($stream);
                fwrite($stream,$elementsTab[$i +1]);
                rewind($stream);
                $data[$fileName] = $stream;
                // dd($data);
            }
                $val=$elementsTab[$i+1];
                $val = str_replace(["\r\n", "--"],'',($elementsTab[$i+1]));
                //dd($val);
                $data[$key] = $val;
               // dd($data[$key]);
           
        }
            //dd($data);
            // dd($data["profil"]);
            if (isset($data["profil"])) {
                $prof=$this->profilRepo->findOneBy(['libelle'=>$data["profil"]]);
                $data["profil"] = $prof;
            }
       
        // dd($prof);
        return $data;

    }
}