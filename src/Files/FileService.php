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

    function findFileById($id)
    {
        $file = $this->fileRepository->find($id);

        if ($file === null)
        {
            return new Response(null);
        }

        $streamContents = stream_get_contents($file->getFile(), -1, -1);
        $file->setFile($streamContents);

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

    function deleteFileById($id)
    {        
        $file = $this->findFileById($id);
        $this->fileRepository->remove($file);
        return $file;
    }
}
