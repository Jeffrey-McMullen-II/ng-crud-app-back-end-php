<?php declare(strict_types = 1);

namespace App\Files;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Core\Controllers\BaseController;
use App\Core\Mappers\JsonMapper;
use App\Core\Pagination\PaginationRequest;
use App\Files\FileService;

/**
 * @Route("/files")
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
     * @Route("/images")
     * @Method("GET")
     */
    function findImageFile(Request $request)
    {
        $response = $this->fileService->findImageFile
        (
                $request->query->get('fileName'),
                $request->query->get('width'),
                $request->query->get('height'),
                $request->query->get('title')
        );
        
        return new Response($response);
    }
    
    /**
     * @Route("/images/pages")
     * @Method("POST")
     */
    function findImageFilesBy(Request $request)
    {
        $paginationRequest = $this->toObject($request->getContent(), PaginationRequest::class);
        
        $paginationResponse = $this->fileService->findImageFilesBy($paginationRequest);
        
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
    function deleteFileBy(int $fileId)
    {
        $file = $this->fileService->deleteFileBy($fileId);

        return new Response($file);
    }
}
