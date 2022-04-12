<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Animal;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimalCrudController extends CustomAbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animal::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield AssociationField::new('category');
        yield IntegerField::new('lifeExpectancy');
        yield BooleanField::new('videoLink')->onlyOnIndex()->setDisabled(true);
        yield TextField::new('videoLink')->onlyOnForms();
        yield from $this->yieldDefaultField();
    }
}
