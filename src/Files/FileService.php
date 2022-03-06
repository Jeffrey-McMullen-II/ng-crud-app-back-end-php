<?php declare(strict_types = 1);

namespace App\Files;

use App\Core\Pagination\PaginationRequest;
use App\Core\Pagination\PaginationResponse;
use App\Files\File;
use App\Files\FileRepository;

class FileService
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    function findFileBy(int $fileId): ?File
    {
        return $this->fileRepository->find($fileId);
    }
    
    function findImageFileContentsBy(string $fileName, ?string $title): ?string
    {
        $fileContents = $this->fileRepository->findImageFileContentsBy($fileName);

        if ($fileContents === null) {
            return '<body style="margin:0;">' . '404' . '</body>';
        }
        
        $image = '<img ' .
                    'width=100%" ' .
                    'height="100%" ' .
                    ($title !== null ? 'title="' . $title . '" ' : '') .
                    'src="' . $fileContents . '"' .
                 '/>';
        
        return '<body style="margin:0;">' . $image . '</body>';
    }
    
    function findImageFilesBy(PaginationRequest $paginationRequest): PaginationResponse
    {        
        return $this->fileRepository->findImageFilesBy($paginationRequest);
    }

    function createFile(File $file)
    {
        $this->fileRepository->create($file);
    }
    
    function transferFiles(): string
    {
        $fileCount = 0;
        $filesTransferred = "";
        
        $directoryPath = "../../file-transfer/";
        $directoryHandle = opendir($directoryPath);
        
        while ($directoryHandle)
        {
            $fileName = readdir($directoryHandle);
            
            if (!$fileName) { closedir($directoryHandle); break; }
            if (in_array($fileName, [".", "..", "index.html"])) { continue; }
            
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
        $this->fileRepository->update($file);
    }

    function deleteFileBy(int $fileId): ?File
    {
        $file = $this->findFileBy($fileId);
        
        if ($file !== null)
        {
            $this->fileRepository->delete($file);
        }
        
        return $file;
    }
}
