<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\services\TransactionService;
use App\Repository\ClientsRepository;
use App\Repository\ComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class TransactionController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/user/transactions",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\TransactionController::postransaction",
     *          "__api_resource_class"=Transaction::class,
     *          "__api_collection_operation_name"="post_transaction",
     *          "normalization_context"={"groups"={"transaction_read","transaction_details_read"}}
     *     }
     * )
     */
    public function postransaction (Request $request, EntityManagerInterface $manager, ComptesRepository $comptesdepot, SerializerInterface $serialize ,TransactionService $service )
    {
        
        $transactionjson=$request->getContent();
      $transactiontab=$serialize->decode($transactionjson,"json");
     $comptesobjet=$comptesdepot->find($transactiontab['compteDepot']['id']);
     unset($transactiontab['compteDepot']);
    $clientdepot=$serialize->denormalize($transactiontab['clientDepot'],'App\Entity\Clients');
    $clientretrait=$serialize->denormalize($transactiontab['clientRetrait'],'App\Entity\Clients');
    unset($transactiontab['clientDepot']);
    unset($transactiontab['clientRetrait']);
    $transaction=$serialize->denormalize($transactiontab,'App\Entity\Transaction');
    $transaction->setComptes($comptesobjet);
    $transaction->setClients($clientdepot);
    $transaction->setClientsRetrait($clientretrait);
    $transaction->setUser($this->get('security.token_storage')->getToken()->getUser());
   $frais=$service-> calculeFraisTotal($transaction->getMontant());
   $transaction->setFrais($frais);
        $transaction->setFraisDepot($frais*0.1);
        $transaction->setFraisRetrait($frais*0.2);
        $transaction->setFraisEtat($frais*0.4);
        $transaction->setFraisSystem($frais*0.3);
        $manager->persist($transaction);
        $manager->flush();
        $transaction->setCodeTransaction($service->GenerateCode($transaction->getId()));
        $manager->flush();
        return $this -> json($transaction, Response::HTTP_CREATED,);
    }

    /**
     * @Route(
     *     path="/api/user/transactions/{id}",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\TransactionController::putransaction",
     *          "__api_resource_class"=Transaction::class,
     *          "__api_collection_operation_name"="put_transactin",
     *          "normalization_context"={"groups"={"transaction_read","transaction_details_read"}}
     *     }
     * )
     */
    public function putransaction (Request $request, EntityManagerInterface $manager, ComptesRepository $comptesretrait, SerializerInterface $serialize ,TransactionService $service,TransactionRepository $transrepo, ClientsRepository $clientrepo,$id )
    {
       
        $transactionjson=$request->getContent();
       
      $transactiontab=$serialize->decode($transactionjson,"json");
     $comptesobjet=$comptesretrait->find($transactiontab['comptesRetrait']['id']);
     $transaction=$transrepo->find($id);

     $clientRetrait=$transaction->getClientsRetrait()->setNumeroCni($transactiontab['clientRetrait']['numeroCni']);
    $transaction->setClientsRetrait($clientRetrait);
    $transaction->setComptesRetrait($comptesobjet);
    $transaction->setUserRetrait($this->get('security.token_storage')->getToken()->getUser());
    $transaction->setDateRetrait(new \DateTime());
    $transaction->setIsRetired( $this->isRetired=true) ;
   
        $manager->persist($transaction);
        $manager->flush();
    
        return $this -> json($transaction, Response::HTTP_CREATED,);
    }
 /**
     * @Route(
     *     path="/api/user/transactions/montant",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\TransactionController::FraisForMontant",
     *          "__api_resource_class"=Transaction::class,
     *          "__api_collection_operation_name"="filter_transaction_montant",
     *          
     *     }
     * )
     */
    public function FraisForMontant(Request $request,SerializerInterface $serializer,EntityManagerInterface $manager,TransactionService $service)
    {
        $montant=$request->get('montant');
        $frais=$service->calculeFraisTotal($montant);
        return $this -> json($frais, Response::HTTP_OK,);
    }


/**   
    * @Route(path="/api/user/{id}/depotTransactions",
    * name="getDepotTransByIdUser", methods={"GET"}) 
    */
 public function getDepotTransByIdUser($id, SerializerInterface $serializer, UserRepository $usersRepo, TransactionRepository $transRepo) 
        { $user = new User(); 

        { $user = $usersRepo->findOneBy([ "id" => $id ]);
        if (!$user)
        { return $this->json( ["message" => "Désolé, mais ce user n'existe pas."], Response::HTTP_FORBIDDEN );
        }
          $depotTransactions = $transRepo->findBy([ "user" => $id ]); 
         array_multisort($depotTransactions);
 return $this->json($depotTransactions, 200, [], ["groups" => ["getDepotTransByIdUser"]]); }
    }
/** 
    *@Route(path="/api/user/{id}/retraitTransactions", 
    *   name="getRetraitTransByIdUser", methods={"GET"}) 
    */
     public function getRetraitTransByIdUser($id, SerializerInterface $serializer, UserRepository $usersRepo, TransactionRepository $transRepo)
     { $user = new User(); 

        { $user = $usersRepo->findOneBy([ "id" => $id ]);
        if (!$user)
        { return $this->json( ["message" => "Désolé, mais ce user n'existe pas."], Response::HTTP_FORBIDDEN );
        }
          $retraitTransactions = $transRepo->findBy([ "userRetrait" => $id ]); 
         array_multisort($retraitTransactions);
 return $this->json($retraitTransactions, 200, [], ["groups" => ["getRetraitTransByIdUser"]]); }
    }
    
}
