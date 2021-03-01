<?php

namespace App\Controller\Admin;

use App\Entity\Transaction;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TransactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transaction::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            NumberField::new('montant'),
            DateField::new('date_depot'),
            DateField::new('date_retrait'),
            TextField::new('code_transaction'),
            NumberField::new('frais'),
            NumberField::new('frais_depot'),
            NumberField::new('frais_retrait'),
            NumberField::new('frais_etat'),
            NumberField::new('frais_system'),
            AssociationField::new('comptes'),

           
        ];
    }
    
}
