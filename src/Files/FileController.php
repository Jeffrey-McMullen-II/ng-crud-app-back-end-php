<?php

namespace App\Files;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Core\Controllers\BaseController;
use App\Files\FileService;

/**
 * @Route("/api/files")
 */
class FileController extends BaseController
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        parent::__construct();
        $this->fileService = $fileService;
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    function findFileById($id)
    {
        $file = $this->fileService->findFileById($id);

        return new Response($this->objToJson($file));
    }

    /**
     * @Route
     * @Method("POST")
     */
    function createFile(Request $request)
    {
        $file = $this->jsonToObj($request->getContent(), File::class);
        
        $this->fileService->createFile($file);
        
        return new Response($this->objToJson($file));
    }

    /**
     * @Route
     * @Method("PUT")
     */
    function updateFile(Request $request)
    {
        $file = $this->jsonToObj($request->getContent(), File::class);

        $this->fileService->updateFile($file);
 
        return new Response($file);
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    function deleteFileById($id)
    {
        $file = $this->fileService->deleteFileById($id);

        return new Response($file);
    }
}
