<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Category;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends CustomAbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield CollectionField::new('animals')
            ->setDisabled(true)
            ->renderExpanded(false)
            ->allowAdd(false)
            ->allowDelete(false);

        yield   BooleanField::new('isDeleted');
    }
}
