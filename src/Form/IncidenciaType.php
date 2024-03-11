<?php

namespace App\Form;

use App\Entity\Incidencia;
use App\Entity\Cliente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IncidenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titulo')
        ->add('fechaCreacion')
        ->add('estado', ChoiceType::class, [
            'choices' => [
                'Iniciada' => 'iniciada',
                'En Proceso' => 'en_proceso',
                'Resuelta' => 'resuelta',
            ],
            'expanded' => true,
            'multiple' => false, 
        ])
        ->add('cliente', EntityType::class, [
            'class' => Cliente::class,
            'choice_label' => 'nombre',
            'label' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incidencia::class,
        ]);
    }
}
