<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Evaluation;
use App\Entity\EvaluationItem;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'name',
            ])
            ->add('EvaluationItem', EntityType::class, [
                'class' => EvaluationItem::class,
                'choice_label' => function (EvaluationItem $evaluationItem) {
                    return $evaluationItem->getCriteria() . ' - ' . $evaluationItem->getLevel(); // Customize the label format
                },
                'multiple' => true,
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
