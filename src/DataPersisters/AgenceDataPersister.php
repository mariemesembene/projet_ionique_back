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

class AgenceDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function supports($data,array $contex=[]): bool
    {
        return ($data instanceof Agences);
    }
    
    public function persist($data,array $contex=[])
    {
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    
    public function remove($data,array $contex=[])
    {
     
        $data->getComptes()->setStatut(true);
        foreach ($data->getUsers() as  $user) {
            $user->setStatut(true);
        }
        $data->setStatut(true);//Mettre le statut à true pour montrer qu'on l'archive
        $this->entityManager->flush();
        return new JsonResponse($data);   
    }
    
}