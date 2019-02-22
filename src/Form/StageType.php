<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('showDateBegin', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('showDateEnd', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateBegin', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateEnd', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('name')
            ->add('price')
            ->add('description', TextareaType::class)
            ->add('info', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
