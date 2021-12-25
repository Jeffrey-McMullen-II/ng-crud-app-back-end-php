<?php declare(strict_types = 1);

namespace App\Core\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Core\Mappers\JsonMapper;

class BaseController extends AbstractController
{
    private JsonMapper $jsonMapper;

    public function __construct(JsonMapper $jsonMapper)
    {
        $this->jsonMapper = $jsonMapper;
    }

    function deserialize(string $content, string $className): mixed
    {
        return $this->jsonMapper->deserialize($content, $className);
    }

    function serialize(mixed $content): string
    {
        return $this->jsonMapper->serialize($content);
    }
}
