<?php

namespace App\Form;

use App\Entity\Attivita;
use App\Entity\Student;
use App\Entity\EvaluationModel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValutazioneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('partecipazione', ChoiceType::class, [
                'choices' => [
                    'ottimo' => 'ottimo',
                    'molto bene' => 'molto bene',
                    'bene' => 'bene',
                    'abbastanza' => 'abbastanza',
                    'male' => 'male',
                    'terribile' => 'terribile',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ])
            ->add('comportamento', ChoiceType::class, [
                'choices' => [
                    'ottimo' => 'ottimo',
                    'molto bene' => 'molto bene',
                    'bene' => 'bene',
                    'abbastanza' => 'abbastanza',
                    'male' => 'male',
                    'terribile' => 'terribile',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ])
            ->add('impegno', ChoiceType::class, [
                'choices' => [
                    'ottimo' => 'ottimo',
                    'molto bene' => 'molto bene',
                    'bene' => 'bene',
                    'abbastanza' => 'abbastanza',
                    'male' => 'male',
                    'terribile' => 'terribile',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ])
            ->add('rapportiConAltri', ChoiceType::class, [
                'choices' => [
                    'ottimo' => 'ottimo',
                    'molto bene' => 'molto bene',
                    'bene' => 'bene',
                    'abbastanza' => 'abbastanza',
                    'male' => 'male',
                    'terribile' => 'terribile',
                ],
                'expanded' => true, 
                'multiple' => false, 
            ])
            ->add('nomeAttivita', EntityType::class, [
                'class' => Attivita::class,
                'choice_label' => 'nome',
            ])
            ->add('nomeStudente', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'nome',
            ])
            ->add('data', DateType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EvaluationModel::class,
        ]);
    }
}
    