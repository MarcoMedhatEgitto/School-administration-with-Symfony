<?php

namespace App\Controller\Admin;

use App\Entity\EvaluationItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EvaluationItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EvaluationItem::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
//            TextField::new('title'),
            AssociationField::new('evaluationModel'),
            AssociationField::new('criteria'),
            AssociationField::new('level'),
            TextEditorField::new('description'),
        ];
    }

}
