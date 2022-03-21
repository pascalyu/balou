<?php

namespace App\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Vich\UploaderBundle\Storage\StorageInterface;

class PictureGalleryNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private const ALREADY_CALLED = 'MEDIA_OBJECT_NORMALIZER_ALREADY_CALLED';

    public function __construct(private ObjectNormalizer $normalizer, private StorageInterface $storage)
    {
    }

    public function normalize($object, $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $context[self::ALREADY_CALLED] = true;

        $object->setContentUrl("http://localhost:80" . $this->storage->resolveUri($object, 'file'));

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, $format = null): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        return $data instanceof \App\Entity\PictureGallery;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
