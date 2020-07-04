<?php declare(strict_types = 1);

namespace App\Core\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BaseController extends AbstractController {

    private Serializer $serializer;

    public function __construct() {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    function jsonToObj($json, $class) {
        return $this->serializer->deserialize($json, $class, 'json');
    }

    function objToJson($obj) {
        return $this->serializer->serialize($obj, 'json');
    }
}
