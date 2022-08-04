<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('logo')->setBasePath('uploads/')
            ->setUploadDir('public/uploads/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            ColorField::new('logoColor'),
            TextField::new('city'),
            TextField::new('website'),
            NumberField::new('phone'),
//            AssociationField::new('fk_user')
        ];
    }

}
