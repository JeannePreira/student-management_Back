<?php

namespace App\Controller;

use App\Entity\Referentiel;
use App\Services\ReferentielService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
   /**
     * @Route(
     *      name="addReferentiel" ,
     *      path="/api/admin/referentiel" ,
     *     methods={"POST"} ,
     *     defaults={
     *         "__controller"="App\Controller\ReferentielController::addReferentiel",
     *         "_api_resource_class"=Referentiel::class,
     *         "_api_collection_operation_name"="adReferentiel"
     *     }
     *)
    */

    public function adReferentiel( Request $request, ReferentielService $ReferentielService , EntityManagerInterface $manager){
       
        if(!($this->isGranted('ROLE_ADMIN')))
        {
            return $this->json(["message"=>"Acces Refuse"],Response:: HTTP_BAD_REQUEST);
        }
      
        $Referentiel = $ReferentielService->addReferentiel($request);
        if(!($Referentiel instanceof Referentiel)){
            return new JsonResponse($Referentiel, Response::HTTP_BAD_REQUEST);
        }
        
        $manager->persist($Referentiel);
        $manager->flush();

        return new JsonResponse(["message"=>"Referentiel Add", Response::HTTP_CREATED]);
    }

}
