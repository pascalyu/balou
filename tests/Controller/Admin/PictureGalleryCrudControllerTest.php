<?php

namespace App\Controller\Admin;

use App\Tests\Controller\AbstractAdminTest;
use App\Entity\PictureGallery;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PictureGalleryCrudControllerTest extends AbstractAdminTest
{
    public function testCreatePicture()
    {
        $client = static::createClient();
        $entityName = "PictureGallery";
        $crawler =  $this->getCreateEntityCrawler($entityName, $client);
        $form = $crawler->selectButton('Create')->form();
        $entityNametoken = $entityName . "__token";
        $token = $this->getTokenFromCrawler($entityNametoken, $crawler);
        $pictureGalleries = self::getContainer()->get('doctrine')->getRepository(PictureGallery::class)->findAll();
        $pictureGalleriesCountBeforeCreate = count($pictureGalleries);
        $uploadedFile = new UploadedFile(
            __DIR__ . '/../../Files/dogpicture.jpeg',
            'dogpicture.jpeg'
        );
        $client->submit(
            $form,
            [
                'PictureGallery[animal]' => "2",
                'PictureGallery[file][file]' => $uploadedFile,
                'PictureGallery[_token]' => $token
            ]
        );
        $pictureGalleries = self::getContainer()->get('doctrine')->getRepository(PictureGallery::class)->findAll();
        $this->assertCount($pictureGalleriesCountBeforeCreate + 1, $pictureGalleries);
    }
}
