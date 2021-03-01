<?php

namespace App\Controller\Admin;

use App\Entity\Agences;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AgencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agences::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
            return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('telephone'),
            TextField::new('adresse'),
            NumberField::new('latitude'),
            NumberField::new('longitude'),
            AssociationField::new('users'),

           
        ];
    }
    
}
