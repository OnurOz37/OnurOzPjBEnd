<?php

namespace App\Controller\Admin;

use App\Entity\Candidates;
use App\Entity\Offers;
use App\Form\OfferType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidatesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidates::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname'),
            TextField::new('lastname'),
            TelephoneField::new('phone'),
            EmailField::new('email'),
            ImageField::new('cv')->setBasePath('cv/')
                ->setUploadDir('public/cv/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            AssociationField::new('offers')

        ];
    }

}
