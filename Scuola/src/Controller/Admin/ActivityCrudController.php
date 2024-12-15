<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\Classroom;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use Doctrine\ORM\EntityManagerInterface;

class ActivityCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Activity::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('name'),
            DateTimeField::new('startedAt'),
            AssociationField::new('evaluationModel'),
            AssociationField::new('classroom')
                ->setFormTypeOption('query_builder', function () {
                    return $this->entityManager->getRepository(Classroom::class)->createQueryBuilder('c')
                        ->leftJoin('c.activities', 'a')
                        ->where('a.id IS NULL');
                })
        ];
    }

}
