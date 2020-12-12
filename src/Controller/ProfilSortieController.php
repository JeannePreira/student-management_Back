<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilSortieController extends AbstractController
{
    /**
     * @Route(
     *  "/api/profil_sortie", 
     *  name="get_profil_sortie_by_promo"
     *  
     * )
     */
    public function index(): Response
    {
        return $this->render('profil_sortie/index.html.twig', [
            'controller_name' => 'ProfilSortieController',
        ]);
    }
}
