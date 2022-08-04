<?php

namespace App\Form;

use App\Entity\Candidates;
use App\Entity\Offers;
use Faker\Provider\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'=>'Prénom',
                'attr'=>[
                    'placeholder'=>'Ex: John'
                ]
            ])
            ->add('lastname',TextType::class, [
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Ex: Doe'
                ]
            ])
            ->add('phone', IntegerType::class, [
                'label'=>'Votre numéro de téléphone',

                'attr'=>[
                    'placeholder'=>'Ex: 060606076',




                ]
            ])
            ->add('email', EmailType::class, [
                'label'=>'Email',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Ex: johndoe@mail.com'
                ]
            ])
            ->add('cv', FileType::class,
            [
                'label' => 'CV (PDF file)',


                // unmapped means that this field is not associated to any entity property


                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes


            ])
//            ->add('offers')
//                ->add('offers', EntityType::class, [
//                    'class'=>Offers::class,
//                    'choice_label'=>'title'
//            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Postuler'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidates::class,
        ]);
    }
}
