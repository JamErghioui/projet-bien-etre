<?php

namespace App\Form;

use App\Entity\Internaut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminInternautType extends AbstractType
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
            ->add('sub_date',DateTimeType::class, [
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
            'data_class' => Internaut::class,
        ]);
    }
}
