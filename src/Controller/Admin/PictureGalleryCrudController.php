<?php

namespace App\Controller\Admin;

use App\Entity\PictureGallery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PictureGalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PictureGallery::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('filePath', 'image')
            ->onlyOnIndex()
            ->setBasePath('/media/');
        yield TextareaField::new('file')
            ->onlyOnForms()
            ->setFormType(VichImageType::class);

        yield AssociationField::new('animal');
    }
}
