<?php

namespace App\Entity\Animal;

use App\Entity\PictureGallery;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource]
class Animal
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: PictureGallery::class)]
    private $picturegalleries;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'animals')]
    private $category;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $lifeExpectancy;

    public function __construct()
    {
        $this->picturegalleries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, PictureGallery>
     */
    public function getPicturegalleries(): Collection
    {
        return $this->picturegalleries;
    }

    public function addPicturegallery(PictureGallery $picturegallery): self
    {
        if (!$this->picturegalleries->contains($picturegallery)) {
            $this->picturegalleries[] = $picturegallery;
            $picturegallery->setAnimal($this);
        }

        return $this;
    }

    public function removePicturegallery(PictureGallery $picturegallery): self
    {
        if ($this->picturegalleries->removeElement($picturegallery)) {
            // set the owning side to null (unless already changed)
            if ($picturegallery->getAnimal() === $this) {
                $picturegallery->setAnimal(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getLifeExpectancy(): ?int
    {
        return $this->lifeExpectancy;
    }

    public function setLifeExpectancy(?int $lifeExpectancy): self
    {
        $this->lifeExpectancy = $lifeExpectancy;

        return $this;
    }
}
