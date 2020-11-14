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
class FileController extends BaseController {

    private FileService $fileService;

    public function __construct(FileService $fileService) {
        parent::__construct();
        $this->fileService = $fileService;
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    function findFileById($id) {
        $file = $this->fileService->findFilfileValueeById($id);
        
        return new Response($file.file);
    }

    /**
     * @Route
     * @Method("POST")
     */
    function createFile(Request $request) {
        $file = new File();
        $file->setName($_POST['name']);
        $file->setType($_POST['type']);
        $file->setFile("test");
        $file->setFile(file_get_contents($_FILES['file']['tmp_name']));

        $theFile = file_get_contents($_FILES['file']['tmp_name']);

        //$this->fileService->createFile($file);

        return new Response($theFile);


        //$file = $this->jsonToObj($request->getContent(), File::class);
        
        //$this->fileService->createFile($file);
        
        //return new Response($this->objToJson($file));
    }

    /**
     * @Route
     * @Method("PUT")
     */
    function updateFile(Request $request) {
        $file = $this->jsonToObj($request->getContent(), File::class);

        $this->fileService->updateFile($file);
 
        return new Response($file);
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    function deleteFileById($id) {
        $file = $this->fileService->deleteFileById($id);

        return new Response($file);
    }
}
