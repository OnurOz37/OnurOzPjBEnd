<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Offers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Titre de votre article',
                'required'=>true,
                'constraints'=>new Length(
                    [
                        'min'=>2,
                        'minMessage'=>'Trop court c\'est {{ limit }} minimum',
                        'max'=>50,
                        'maxMessage'=>'Trop long.'
                    ]
                ),
                'attr'=>[
                    'class'=>'tinymce',
                    'placeholder'=>'Veuillez ecrire le titre de votre annonce'
                ]
            ])
            ->add('type', TextType::class, [
                'label'=>'Type de contrat',
                'attr'=>[
                    'placeholder'=>'Ex: CDI'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label'=>'Description du poste'
            ])
//            ->add('postedAt', DateTimeType::class, [
//                'label'=>'Date de publication'
//            ])
            ->add('website', TextType::class, [
                'label'=>'Site Web',
                'attr'=>[
                    'placeholder'=>'Ex: test.Com'
                ]
            ])
            ->add('requirements_item', TextareaType::class, [
                'label'=>'Description du profil recherché'
            ])
            ->add('requirements_content', TextareaType::class, [
                'label'=>'Compéténces nécéssaires'
            ])
            ->add('role_item', TextareaType::class, [
                'label'=>'Description du poste'
            ])
            ->add('role_content', TextareaType::class, [
                'label'=>'Les missions demandées'
            ])
//            ->add('fk_company', EntityType::class, [
//                'class'=>Company::class,
//                'choice_label'=>'name',
//                'label'=>'Entreprise'
//
//            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Ajouter offre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offers::class,
        ]);
    }
}
