<?php

namespace App\Form;

use App\Entity\District;
use App\Entity\Locality;
use App\Entity\Vendor;
use App\Entity\ZipCode;
use App\Repository\DistrictRepository;
use App\Repository\LocalityRepository;
use App\Repository\ZipCodeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminVendorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('contact_mail', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('vat', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('website', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('door_number', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('street', TextType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('district', EntityType::class, [
                'disabled' => true,
                'placeholder' => 'Choose your district',
                'query_builder' => function (DistrictRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'class' => District::class,
                'choice_label' => 'name'
            ])
            ->add('zipcode', EntityType::class, [
                'disabled' => true,
                'placeholder' => 'Choose your zipcode',
                'query_builder' => function (ZipCodeRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.number', 'ASC');
                },
                'class' => ZipCode::class,
                'choice_label' => 'number'
            ])
            ->add('locality', EntityType::class, [
                'disabled' => true,
                'placeholder' => 'Choose your locality',
                'query_builder' => function (LocalityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'class' => Locality::class,
                'choice_label' => 'name'
            ])
            ->add('sub_date', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'readonly' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vendor::class,
        ]);
    }
}
