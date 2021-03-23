<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{/**
     * @Route(
     *     path="/api/user/roles",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::getroles",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="get_roles",
     *         
     *     }
     * )
     */
    public function getroles (Request $request ){
        
            $user=$this->get('security.token_storage')->getToken()->getUser()-> getRoles();
            return $this -> json($user, Response::HTTP_OK,);
        


    }

    /**
     * @Route(
     *     path="/api/user",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::getusers",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="getusers",
     *         
     *     }
     * )
     */

         public function getusers (Request $request ){
        
        $user=$this->get('security.token_storage')->getToken()->getUser();
        return $this -> json($user, Response::HTTP_OK,);
    

}


}
