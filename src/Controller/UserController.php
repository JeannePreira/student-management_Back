<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
 
/**
     * @Route(
     *      name="addUser" ,
     *      path="/api/admin/users" ,
     *     methods={"POST"} ,
     *     defaults={
     *         "__controller"="App\Controller\UserController::addUser",
     *         "_api_resource_class"=User::class,
     *         "_api_collection_operation_name"="adUser"
     *     }
     *)
    */

    public function adUser( Request $request, UserService $userService , EntityManagerInterface $manager) {
        if(!($this->isGranted('ROLE_ADMIN')))
        {
            return $this->json(["message"=>"Acces Refuse"],Response:: HTTP_BAD_REQUEST);
        }
      
        $user = $userService->addUser($request);
        if(!($user instanceof User)){
            return new JsonResponse($user, Response::HTTP_BAD_REQUEST);
        }
        $userService->sendMail($user);
        $manager->persist($user);
        $manager->flush();

        return new JsonResponse(["message"=>"User Add", Response::HTTP_CREATED]);
    }

    /**
     * @Route(
     *      name="putUser" ,
     *      path="/api/admin/users/{id}" ,
     *     methods={"PUT"} ,
     *     defaults={
     *         "_controller"="App\Controller\UserController::modifUser",
     *         "_api_resource_class"=User::class,
     *         "_api_item_operation_name"="putUser"
     *     }
     *)
    */

    
    public function modifUser($id,UserService $service,Request $request, UserRepository $repo, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder){
        $user=$service->PutUser($request,'avatar');
        // dd($user);
        $utilisateurs=$repo->find($id);
        $utilisateurs->setDeleted(0);
        // dd($utilisateurs);
        foreach ($user as $key => $valeur) {
            $setter='set'.ucfirst(strtolower($key));
            // dd($setter);
            if(method_exists(User::class, $setter)){
                if($setter=='setProfil'){
                    $utilisateurs->setProfil($user["profil"]);
                }
               
                    // dd($valeur);
                    $utilisateurs->$setter($valeur);

            }
            if ($setter=='setPassword'){
                // dd($encoder);
                $utilisateurs->setPassword($encoder->encodePassword($utilisateurs,$user['password']));
                // dd($encoder);

            }
        }
        //dd($utilisateur);
        $em->persist($utilisateurs);
        $em->flush();
        return new JsonResponse(["message"=>"User Update", Response::HTTP_CREATED]);
        }
        

         /**
     * @Route(
     *      name="deleteUser" ,
     *      path="/api/admin/users/{id}" ,
     *     methods={"DELETE"} ,
     *     defaults={
     *         "_controller"="App\Controller\UserController::deleteUser",
     *         "_api_resource_class"=User::class,
     *         "_api_item_operation_name"="deleteUser"
     *     }
     *)
    */

    function deleteUser($id, UserRepository $repo, EntityManagerInterface $manager){
        $utilisateurs=$repo->find($id);
        $utilisateurs->setDeleted(1);
        $manager->persist($utilisateurs);
        $manager->flush();
        return new JsonResponse(["message"=>"User Update", Response::HTTP_CREATED]);
        // dd($utilisateurs);


    }
}
