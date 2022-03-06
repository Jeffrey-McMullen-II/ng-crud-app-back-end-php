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
     * @Route("/images/contents")
     * @Method("GET")
     */
    function findImageFileContentsBy(Request $request)
    {
        $image = $this->fileService->findImageFileContentsBy
        (
            $request->query->get("fileName"),
            $request->query->get("title")
        );
        
        $response = new Response($image);
        $age = $request->query->get("age");
        
        if ($age !== null)
        {
            $response->setCache(["private" => true, "max_age" => $age]);
        }
        
        return $response;
    }
    
    /**
     * @Route("/images/pages")
     * @Method("POST")
     */
    function findImageFilesBy(Request $request)
    {
        $paginationRequest = $this->deserialize($request->getContent(), PaginationRequest::class);
        
        $paginationResponse = $this->fileService->findImageFilesBy($paginationRequest);
        
        return new Response($this->serialize($paginationResponse));
    }

    /**
     * @Route
     * @Method("POST")
     */
    function createFile(Request $request)
    {
        $file = $this->deserialize($request->getContent(), File::class);
        
        $this->fileService->createFile($file);
        
        return new Response($this->serialize($file));
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
        $file = $this->deserialize($request->getContent(), File::class);

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
