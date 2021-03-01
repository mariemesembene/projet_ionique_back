<?php

namespace App\Controller\Admin;

use App\Entity\Comptes;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ComptesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comptes::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('numero_compte'),
            NumberField::new('solde'),
            DateField::new('date_creation'),
           

           
        ];
    }
    
}
