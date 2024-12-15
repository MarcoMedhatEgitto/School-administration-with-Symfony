<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\EvaluationItem;
use App\Entity\Student;
use App\Repository\EvaluationItemRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotAdminEvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => function (Student $student) {
                    return sprintf("[%s] %s %s",
                        $student->getClassroom(), $student->getName(), $student->getSurname()
                    );
                },
                'query_builder' => function (StudentRepository $er) use ($options): QueryBuilder {
                    return $er->createQueryBuilder('s')
                        ->join('s.classroom', 'sc')
                        ->join('sc.activities', 'sca')
                        ->andWhere('sca.id = :activity')
                        ->setParameter('activity', $options['activity']->getId());
                },
            ])
            ->add('evaluationItem', EntityType::class, [
                'class' => EvaluationItem::class,
                'choice_label' => function (EvaluationItem $evaluationItem) {
                    return $evaluationItem->getCriteria().' '.$evaluationItem->getLevel();
                },
                'query_builder' => function (EvaluationItemRepository $er) use ($options): QueryBuilder {
                    return $er->createQueryBuilder('e')
                        ->join('e.evaluationModel', 'ee')
                        ->join('ee.activities', 'eea')
                        ->andWhere('eea.id = :activity')
                        ->setParameter('activity', $options['activity']->getId());
                },
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Evaluation::class,
            ])
            ->setRequired([
                'activity',
            ]);
    }
}
