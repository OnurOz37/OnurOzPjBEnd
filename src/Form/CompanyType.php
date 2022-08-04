<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('name', TextType::class, [
                'label'=>"Nom d'entrprise"
            ])
            ->add('logo', FileType::class, [
                'data_class'=>null
            ])
            ->add('logoColor', ColorType::class, [
                'label'=>'Choisissez la couleur de fond de votre logo',
                'attr' => ['class' => 'tinymce'],

            ])
            ->add('city', TextType::class, [
                'label'=>"Ville"
            ])
            ->add('website', TextType::class, [
                'label'=>"Site Internet"
            ])
            ->add('phone', TelType::class, [
                'label'=>"Numéro de téléphone"
            ])

            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,

        ]);
    }
}
