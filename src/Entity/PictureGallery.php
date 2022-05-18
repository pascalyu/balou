<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Action\CreatePictureGallerytAction;
use App\Entity\Animal\Animal;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\PictureGalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: PictureGalleryRepository::class)]
#[ApiResource(
    iri: 'http://schema.org/MediaObject',
    normalizationContext: ['groups' => ['picture_gallery:read', 'animal:read']],
    itemOperations: ['get'],
    collectionOperations: [
        'get',
        'post' => [
            'controller' => CreatePictureGallerytAction::class,
            'deserialize' => false,
            'validation_groups' => ['Default', 'picture_gallery_create'],
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: true)]

class PictureGallery
{
    use TimestampableEntity;
    use SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    #[Assert\NotNull(groups: ['media_object_create'])]
    private ?File $file = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $filePath = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $croppedFilePath;

    #[ApiProperty(iri: 'http://schema.org/contentUrl')]
    #[Groups(['animal:read', 'picture_gallery:read'])]
    public ?string $contentUrl = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isMain = false;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'picturegalleries')]
    private Animal $animal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
        $this->setName($file->getBasename());
        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getCroppedFilePath(): ?string
    {
        return $this->croppedFilePath;
    }

    public function setCroppedFilePath(?string $croppedFilePath): self
    {
        $this->croppedFilePath = $croppedFilePath;

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    public function setIsMain(bool $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;

        return $this;
    }
}
