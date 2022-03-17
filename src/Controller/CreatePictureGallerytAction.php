<?php

namespace App\Controller;

use App\Entity\PictureGallery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CreatePictureGallerytAction extends AbstractController
{
    public function __invoke(Request $request): PictureGallery
    {

        $uploadedFile = $request->files->get('file');
        /** @var UploadedFile as $uploadedFile*/

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $pictureGallery = new PictureGallery();
        $pictureGallery->setFile($uploadedFile);
        $pictureGallery->setName($uploadedFile->getClientOriginalName());


        return $pictureGallery;
    }
}
