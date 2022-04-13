<?php

namespace App\Controller\Admin;

use App\Entity\PictureGallery;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PictureGalleryCrudController extends CustomAbstractCrudController
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
        yield from $this->yieldDefaultField();
    }
}
