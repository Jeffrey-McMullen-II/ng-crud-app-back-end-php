<?php declare(strict_types = 1);

namespace App\Files;

use App\Files\File;
use App\Files\FileRepository;
use App\Core\Pagination\PaginationResponse;
use App\Core\Pagination\PaginationRequest;

class FileService
{
    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    function findFileByFileId(int $fileId): File
    {
        $file = $this->fileRepository->find($fileId);

        if ($file === null) { return null; }

        $file->setFileContents(stream_get_contents($file->getFileContents(), -1, -1));

        return $file;
    }
    
    function findFile(string $fileName, string $width, string $height, string $title): string
    {
        $fileContents = $this->fileRepository->findFileContentsForFileByName($fileName);

        if ($fileContents === null) { return '404 Not Found'; }
        
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
        $fileCount = $this->fileRepository->findFileCount();
        
        $files = $this->fileRepository->findFilesBy($paginationRequest->getFirst(), $paginationRequest->getRows());
        
        foreach ($files as $file)
        {
            $file->setFileContents(stream_get_contents($file->getFileContents(), -1, -1));
        }
        
        return new PaginationResponse($fileCount, $files);
    }

    function createFile(File $file)
    {
        $this->fileRepository->persist($file);
    }
    
    function transferFiles(): string
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
    
    private function buildBase64File(string $fileName, string $fileType, $fileContent): File
    {
        $file = new File();
        $file->setFileName($fileName);
        $file->setFileType($fileType);
        $file->setFileContents('data:' . $fileType . ';base64,' . $fileContent);
        
        return $file;
    }

    function updateFile(File $file)
    {
        $this->fileRepository->merge($file);
    }

    function deleteFileByFileId(int $fileId): File
    {
        $file = $this->findFileByFileId($fileId);
        
        if ($file === null) { return null; }
        
        $this->fileRepository->remove($file);
        return $file;
    }
}
