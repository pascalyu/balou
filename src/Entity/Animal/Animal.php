<?php

namespace App\Entity\Animal;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Entity\PictureGallery;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['animal:read']],
    itemOperations: ['get'],
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: true)]
class Animal
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['animal:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['animal:read'])]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['animal:read'])]
    private $description;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: PictureGallery::class)]
    private $picturegalleries;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'animals')]
    #[Groups(['animal:read'])]
    private $category;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['animal:read'])]
    private $lifeExpectancy;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $videoLink;

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


    #[Groups(['animal:read'])]
    public function getFirstPicture(): ?PictureGallery
    {
        if (count($this->picturegalleries) > 0) {
            return $this->picturegalleries->first();
        }
        return null;
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
        return "" . $this->getName();
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

    public function getVideoLink(): ?string
    {
        return $this->videoLink;
    }

    public function setVideoLink(?string $videoLink): self
    {
        $this->videoLink = $videoLink;

        return $this;
    }
}
