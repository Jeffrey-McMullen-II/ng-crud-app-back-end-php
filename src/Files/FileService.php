<?php

namespace App\Files;

use App\Files\File;
use App\Files\FileRepository;
use App\Core\Pagination\PaginationResponse;

class FileService
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    function findFileByFileId($fileId)
    {
        $file = $this->fileRepository->find($fileId);

        if ($file === null) { return null; }

        $file->setFileContents(stream_get_contents($file->getFileContents(), -1, -1));

        return $file;
    }
    
    function findFile($fileName, $width, $height, $title)
    {
        $fileContents = $this->fileRepository->findFileByName($fileName);

        if ($fileContents === null) { return '404 Not Found'; }
        
        $image = '<img ' .
                    'src="' . $fileContents . ' "' .
                    'width="' . ($width !== null ? $width : '200') . '" ' .
                    'height="' . ($height !== null ? $height : '200') . '" ' .
                    'title="' . $title . '" ' .
                 '/>';
        
        return '<body style="padding:0; margin:0;">' . $image . '</body>';
    }
    
    function findFilesBy($paginationRequest)
    {
        $fileCount = $this->fileRepository->findFileCount();
        
        $files = $this->fileRepository->findFilesBy($paginationRequest->getFirst(), $paginationRequest->getRows());
        
        foreach ($files as $file)
        {
            $file->setFileContents(stream_get_contents($file->getFileContents(), -1, -1));
        }
        
        return new PaginationResponse($fileCount, $files);
    }

    function createFile($file)
    {
        $this->fileRepository->persist($file);
    }
    
    function transferFiles()
    {
        $directoryPath = '../../files/';
        
        $fileCount = 0;
        $filesTransferred = '';

        if (($directoryHandle = opendir($directoryPath)))
        {
            while (false !== ($fileName = readdir($directoryHandle)))
            {
                if (!in_array($fileName, ['.', '..']))
                {
                    $fileCount++;
                    $filesTransferred .= $fileName . '<br>';
                    
                    $fileType = mime_content_type($directoryPath . $fileName);
                    $fileContent = base64_encode(file_get_contents($directoryPath . $fileName));
                    
                    $this->createFile($this->buildBase64File($fileName, $fileType, $fileContent));
                    
                    unlink($directoryPath . $fileName);
                }
            }
        }
        
        closedir($directoryHandle);
        
        return $fileCount . ' file(s) transferred <br>' . $filesTransferred;
    }
    
    private function buildBase64File($fileName, $fileType, $fileContent)
    {
        $file = new File();
        $file->setFileName($fileName);
        $file->setFileType($fileType);
        $file->setFileContents('data:' . $fileType . ';base64,' . $fileContent);
        
        return $file;
    }

    function updateFile($file)
    {
        $this->fileRepository->merge($file);
    }

    function deleteFileByFileId($fileId)
    {
        $file = $this->findFileByFileId($fileId);
        
        if ($file === null) { return null; }
        
        $this->fileRepository->remove($file);
        return $file;
    }
}
