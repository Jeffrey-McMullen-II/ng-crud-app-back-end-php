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

    function toObject($jsonContents, $className)
    {
        return $this->jsonMapper->toObject($jsonContents, $className);
    }

    function toJson($object)
    {
        return $this->jsonMapper->toJson($object);
    }
}
