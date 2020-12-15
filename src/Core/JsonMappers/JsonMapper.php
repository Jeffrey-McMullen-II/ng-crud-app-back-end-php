<?php declare(strict_types = 1);

namespace App\Core\JsonMappers;

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

    public function toObject($jsonContents, $className)
    {
        return $this->serializer->deserialize($jsonContents, $className, 'json');
    }

    function toJson($object)
    {
        return $this->serializer->serialize($object, 'json');
    }
}
