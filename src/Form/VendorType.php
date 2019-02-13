<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\District;
use App\Entity\Vendor;
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
                'class' => District::class,
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
