<?php

namespace App\Controller;

use App\Repository\AgencesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AgencesController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/agence/{id}/user/{id1}",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\AgencesController::archivageuser",
     *          "__api_resource_class"=Agences::class,
     *          "__api_collection_operation_name"="PUT__agence_USER",
     *          "normalization_context"={"groups"={"bloqueruser:read"}}
     *     }
     * )
     */
    public function archivageuser(EntityManagerInterface $Manager,Request $request,$id,$id1,SerializerInterface $serializerInterface,AgencesRepository $agencesRepository,UserRepository $userRepository){
        $agence=$agencesRepository->find($id);
        $User=$userRepository->find($id1);
        foreach ($agence->getUsers() as  $user) {
            if ($User===$user)
            {
                $User->setStatut(true);
            }
        }

        $Manager->flush();
        return $this -> json($User, Response::HTTP_OK);

    }
}
