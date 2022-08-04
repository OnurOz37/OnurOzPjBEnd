<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom d'entreprise"
            ])
//            ->add('logo', FileType::class, [
//                'mapped'=>false,
//                'required' => false
//            ])
            ->add('logoColor', ColorType::class, [
                'label' => 'Choisissez la couleur de fond de votre logo',
                'attr' => ['class' => 'tinymce'],

            ])
            ->add('city', TextType::class, [
                'label' => "Ville"
            ])
            ->add('website', TextType::class, [
                'label' => "Site Internet"
            ])
            ->add('phone', TelType::class, [
                'label' => "Numéro de téléphone"
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Enregistrer'
            ]);
        }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
