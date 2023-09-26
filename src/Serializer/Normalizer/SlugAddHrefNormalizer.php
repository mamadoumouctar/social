<?php

namespace App\Serializer\Normalizer;

use ApiPlatform\Api\UrlGeneratorInterface;
use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SlugAddHrefNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private UrlGeneratorInterface $router
    ){
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['href'] = $this->router->generate($object instanceof Article ? 'article.show' : 'categorie.show', [
            'id' => $object->getId(),
            'slug' => $object->getSlug()
        ]);

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Article || $data instanceof Categorie;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
