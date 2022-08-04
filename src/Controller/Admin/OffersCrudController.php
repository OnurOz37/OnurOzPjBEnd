<?php

namespace App\Controller\Admin;

use App\Entity\Offers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OffersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offers::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('type'),
            TextareaField::new('description'),
            DateTimeField::new('postedAt'),
            TextField::new('website'),
            TextareaField::new('requirements_item'),
            TextareaField::new('requirements_content'),
            TextareaField::new('role_item'),
            TextareaField::new('role_content'),
            AssociationField::new('fk_company'),


        ];
    }

}
