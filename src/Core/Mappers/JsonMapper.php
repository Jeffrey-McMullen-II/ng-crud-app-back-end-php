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

    function toObject(string $jsonContents, string $className): object
    {
        return $this->serializer->deserialize($jsonContents, $className, 'json');
    }

    function toJson($content): string
    {
        return $this->serializer->serialize($content, 'json');
    }
}
