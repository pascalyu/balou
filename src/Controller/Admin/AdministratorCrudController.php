<?php

namespace App\Controller\Admin;

use App\Entity\Security\Administrator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdministratorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Administrator::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
