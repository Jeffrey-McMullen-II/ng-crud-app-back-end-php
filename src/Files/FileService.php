<?php

namespace App\Files;

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

        if ($file === null)
        {
            return null;
        }

        $streamContents = stream_get_contents($file->getFileContents(), -1, -1);
        $file->setFileContents($streamContents);

        return $file;
    }

    function createFile($file)
    {
        $this->fileRepository->persist($file);
    }

    function updateFile($file)
    {
        $this->fileRepository->merge($file);
    }

    function deleteFileByFileId($fileId)
    {        
        $file = $this->findFileByFileId($fileId);
        
        if ($file === null)
        {
            return null;
        }
        
        $this->fileRepository->remove($file);
        return $file;
    }
}
