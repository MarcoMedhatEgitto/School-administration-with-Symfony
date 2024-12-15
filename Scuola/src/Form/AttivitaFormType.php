<?php

namespace App\Form;

use App\Entity\Attivita;
use App\Entity\Classroom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttivitaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome')
            ->add('dataDiInizio', null, [
                'widget' => 'single_text',
            ])
            ->add('classe', EntityType::class, [
                'class' => Classroom::class,
                'choice_label' => 'nome',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attivita::class,
        ]);
    }
}
