<?php


namespace App\DataPersisters;


use App\Entity\Agence;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Agences;
use App\Entity\Comptes;
use App\Entity\User;
use App\services\TransactionService;

class ComptesDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private $service;

    public function __construct(EntityManagerInterface $entityManager, TransactionService $service)
    {
        $this->entityManager = $entityManager;
        $this->service=$service;
    }
    
    public function supports($data,array $contex=[]): bool
    {
        return ($data instanceof Comptes);
    }
    
    public function persist($data,array $contex=[])
    {
       
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        if ($contex["collection_operation_name"]=="post")
        {
            $data->SetNumeroCompte($this->service->GenerateCode(($data->getId())));
        }
        $this->entityManager->flush();
    }
    
    
    public function remove($data,array $contex=[])
    {
        $data->setStatut(true);//Mettre le statut à true pour montrer qu'on l'archive
        $this->entityManager->flush();
        return new JsonResponse($data);   
    }
    
}