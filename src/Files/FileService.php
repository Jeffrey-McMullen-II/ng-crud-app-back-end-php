<?php

namespace App\Files;

use App\Files\File;
use App\Files\FileRepository;

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

        $streamContents = stream_get_contents($file->getFileContents(), -1, -1);
        $file->setFileContents($streamContents);

        return $file;
    }

    function createFile($file)
    {
        $this->fileRepository->persist($file);
    }
    
    function transferFiles()
    {
        $directoryPath = "../../files/";
        
        $fileCount = 0;
        $filesTransferred = "";

        if (($directory = opendir($directoryPath)))
        {
            while (false !== ($fileName = readdir($directory)))
            {
                if (!in_array($fileName, [".", ".."]))
                {
                    $fileCount++;
                    $filesTransferred .= $fileName . "<br>";
                    
                    $fileType = mime_content_type($directoryPath . $fileName);
                    $fileContent = base64_encode(file_get_contents($directoryPath . $fileName));
                    
                    $file = new File();
                    $file->setFileName($fileName);
                    $file->setFileType($fileType);
                    $file->setFileContents('data: ' . $fileType . ';base64,' . $fileContent);
                    
                    $this->createFile($file);
                    
                    unlink($directoryPath . $fileName);
                }
            }
        }
        
        closedir($directory);
        
        return $fileCount . " file(s) transferred <br>" . $filesTransferred;
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
