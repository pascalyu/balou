<?php

namespace App\Controller;

use App\Entity\PictureGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vich\UploaderBundle\Entity\File;

final class CreatePictureGallerytAction extends AbstractController
{
    public function __invoke(Request $request): PictureGallery
    {
        new File();
        $uploadedFile = $request->files->get('file');


        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $pictureGallery = new PictureGallery();
        $pictureGallery->setFile($uploadedFile);


        return $pictureGallery;
    }
}
