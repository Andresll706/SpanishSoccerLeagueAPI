<?php

namespace App\Serializer;

use App\Entity\Position;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Serializer\Encoder\ContextAwareDecoderInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PositionNormalizer implements NormalizerInterface
{
    private ObjectNormalizer $normalizer;
    private UrlHelper $urlHelper;
    public function __construct(ObjectNormalizer $objectNormalizer, UrlHelper $urlHelper){
        $this->normalizer = $objectNormalizer;
        $this->urlHelper = $urlHelper;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Position;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if(!empty($object->getImage())) {
            $data['image'] = $this->urlHelper->getAbsoluteUrl('/storage/default/' . $data['image']);
        }

        return $data;
    }
}