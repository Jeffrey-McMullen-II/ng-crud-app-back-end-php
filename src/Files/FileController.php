<?php

namespace App\Files;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Core\Controllers\BaseController;
use App\Core\Mappers\JsonMapper;
use App\Files\FileService;
use App\Core\Pagination\PaginationRequest;

/**
 * @Route("/api/files")
 */
class FileController extends BaseController
{
    private FileService $fileService;

    public function __construct(JsonMapper $jsonMapper, FileService $fileService)
    {
        parent::__construct($jsonMapper);
        
        $this->fileService = $fileService;
    }

    /**
     * @Route("/{fileId}")
     * @Method("GET")
     */
    function findFileByFileId($fileId)
    {
        $file = $this->fileService->findFileByFileId($fileId);

        return $file !== null ? new Response($this->toJson($file)) : new Response(null);
    }
    
    /**
     * @Route("/by-pagination-request")
     * @Method("POST")
     */
    function findFilesBy(Request $request)
    {
        $paginationRequest = $this->toObject($request->getContent(), PaginationRequest::class);
        
        $paginationResponse = $this->fileService->findFilesBy($paginationRequest);
        
        return new Response($this->toJson($paginationResponse));
    }

    /**
     * @Route
     * @Method("POST")
     */
    function createFile(Request $request)
    {
        $file = $this->toObject($request->getContent(), File::class);
        
        $this->fileService->createFile($file);
        
        return new Response($this->toJson($file));
    }
    
    /**
     * @Route("/transfer")
     * @Method("POST")
     */
    function transferFiles()
    {
        return new Response($this->fileService->transferFiles());
    }

    /**
     * @Route
     * @Method("PUT")
     */
    function updateFile(Request $request)
    {
        $file = $this->toObject($request->getContent(), File::class);

        $this->fileService->updateFile($file);
 
        return new Response($file);
    }

    /**
     * @Route("/{fileId}")
     * @Method("DELETE")
     */
    function deleteFileByFileId($fileId)
    {
        $file = $this->fileService->deleteFileByFileId($fileId);

        return new Response($file);
    }
}
