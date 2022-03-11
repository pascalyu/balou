<?php

namespace App\Entity;

use App\Entity\Animal\Animal;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\PictureGalleryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureGalleryRepository::class)]
class PictureGallery
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $file;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $filePath;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $croppedFilePath;

    #[ORM\Column(type: 'boolean')]
    private $isMain;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'picturegalleries')]
    private $animal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

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
