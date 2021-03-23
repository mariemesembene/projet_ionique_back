<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptesController extends AbstractController
{
   /**
     * @Route(
     *     path="/api/user/agence/{id}/compte/{id1}",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\ComptesController::getcompte",
     *          "__api_resource_class"=Comptes::class,
     *          "__api_collection_operation_name"="user_agence_compte",
     *         
     *     }
     * )
     */
    public function getcompte (Request $request){
        
        $user=$this->get('security.token_storage')->getToken()->getUser();
        $compte=$user->getAgences()->getcompte();

        return $this -> json($compte, Response::HTTP_OK,);
    

}
}
