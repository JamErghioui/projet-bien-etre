<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\District;
use App\Entity\Locality;
use App\Entity\Vendor;
use App\Entity\ZipCode;
use App\Repository\DistrictRepository;
use App\Repository\LocalityRepository;
use App\Repository\ZipCodeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('contact_mail')
            ->add('phone')
            ->add('vat')
            ->add('website')
            ->add('door_number')
            ->add('street')
            ->add('district', EntityType::class, [
                'placeholder' => 'Choose your district',
                'query_builder' => function (DistrictRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'class' => District::class,
                'choice_label' => 'name'
            ])
            ->add('zipcode', EntityType::class, [
                'placeholder' => 'Choose your zipcode',
                'query_builder' => function (ZipCodeRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.number', 'ASC');
                },
                'class' => ZipCode::class,
                'choice_label' => 'number'
            ])
            ->add('locality', EntityType::class, [
                'placeholder' => 'Choose your locality',
                'query_builder' => function (LocalityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'class' => Locality::class,
                'choice_label' => 'name'
            ])
            ->add('category', EntityType::class,[
                'placeholder' => 'Choose a category',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
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
