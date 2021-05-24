<?php declare(strict_types = 1);

namespace App\Files;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="App\Files\FileRepository")
 */
class File
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="file_id", type="integer")
     */
    private ?int $fileId;
    
    /**
     * @ORM\Column(name="file_name", type="text")
     */
    private string $fileName;

    /**
     * @ORM\Column(name="file_type", type="text")
     */
    private string $fileType;

    /**
     * @ORM\Column(name="file_contents", type="blob")
     */
    private $fileContents;
    
    
    
    public static function base64EncodedOf(string $fileName, string $filePath): File
    {
        $fileType = mime_content_type($filePath);
        $fileContents = file_get_contents($filePath);
        
        $file = new File();
        $file->setFileName($fileName);
        $file->setFileType($fileType);
        $file->setFileContents('data:' . $fileType . ';base64,' . base64_encode($fileContents));
        
        return $file;
    }
    

    
    public function getFileId(): int
    {
        return $this->fileId;
    }

    public function setFileId(?int $fileId)
    {
        $this->fileId = $fileId;
    }
    
    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType)
    {
        $this->fileType = $fileType;
    }

    public function getFileContents(): string
    {
        if ("resource" === gettype($this->fileContents))
        {
            return stream_get_contents($this->fileContents, -1, -1);
        }
        
        return $this->fileContents;
    }

    public function setFileContents(string $fileContents)
    {
        $this->fileContents = $fileContents;
    }
}
