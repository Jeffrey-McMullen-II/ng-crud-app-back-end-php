<?php declare(strict_types = 1);

namespace App\Core\Mappers;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonMapper
{
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    function deserialize(string $content, string $className): mixed
    {
        return $this->serializer->deserialize($content, $className, 'json');
    }

    function serialize(mixed $content): string
    {
        return $this->serializer->serialize($content, 'json');
    }
}
