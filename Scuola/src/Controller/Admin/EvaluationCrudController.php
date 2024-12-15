<?php

namespace App\Controller\Admin;

use App\Entity\Evaluation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EvaluationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evaluation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('student'),
            AssociationField::new('activity'),
            AssociationField::new('EvaluationItem'),
        ];
    }

}
