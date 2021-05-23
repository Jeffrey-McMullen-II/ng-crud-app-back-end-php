<?php declare(strict_types = 1);

namespace App\Files;

use App\Core\Pagination\PaginationResponse;
use App\Core\Pagination\PaginationRequest;
use App\Files\File;
use App\Files\FileRepository;

class FileService
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    function findFileByFileId(int $fileId): File
    {
        return $this->fileRepository->find($fileId);
    }
    
    function findFile(string $fileName, string $width, string $height, string $title): string
    {
        $fileContents = $this->fileRepository->findFileContentsForFileByName($fileName);

        if ($fileContents === null) { return "404 Not Found"; }
        
        $image = '<img ' .
                    'src="' . $fileContents . ' "' .
                    'width="' . ($width !== null ? $width : '200') . '" ' .
                    'height="' . ($height !== null ? $height : '200') . '" ' .
                    'title="' . $title . '" ' .
                 '/>';
        
        return '<body style="padding:0; margin:0;">' . $image . '</body>';
    }
    
    function findFilesBy(PaginationRequest $paginationRequest): PaginationResponse
    {        
        return $this->fileRepository->findFilesBy($paginationRequest);
    }

    function createFile(File $file)
    {
        $this->fileRepository->persist($file);
    }
    
    function transferFiles(): string
    {
        $fileCount = 0;
        $filesTransferred = "";
        
        $directoryPath = "../../files/";
        $directoryHandle = opendir($directoryPath);
        
        while ($directoryHandle)
        {
            $fileName = readdir($directoryHandle);
            
            if (!$fileName) { closedir($directoryHandle); break; }
            if (in_array($fileName, [".", ".."])) { continue; }
            
            $fileCount++;
            $filesTransferred .= $fileName . "<br>";

            $filePath = $directoryPath . $fileName;
            
            $this->createFile(File::base64EncodedOf($fileName, $filePath));

            unlink($filePath);
        }
        
        return $fileCount . " file(s) transferred <br>" . $filesTransferred;
    }

    function updateFile(File $file)
    {
        $this->fileRepository->merge($file);
    }

    function deleteFileByFileId(int $fileId): File
    {
        $file = $this->findFileByFileId($fileId);
        
        if ($file !== null)
        {
            $this->fileRepository->remove($file);
        }
        
        return $file;
    }
}
