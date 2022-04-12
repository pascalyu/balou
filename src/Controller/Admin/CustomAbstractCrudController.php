<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

abstract class CustomAbstractCrudController extends AbstractCrudController
{
    public function yieldDefaultField()
    {
        yield   DateTimeField::new('createdAt')->onlyOnIndex();
        yield   DateTimeField::new('updatedAt')->onlyOnIndex();
        yield   BooleanField::new('isDeleted')->setDisabled(true);
    }
}
