<?php

namespace App\Controller\Admin;

use App\Entity\PictureGallery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PictureGalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PictureGallery::class;
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
