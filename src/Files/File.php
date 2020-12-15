<?php

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
    private $fileId;
    
    /**
     * @ORM\Column(name="file_name", type="text")
     */
    private $fileName;

    /**
     * @ORM\Column(name="file_type", type="text")
     */
    private $fileType;

    /**
     * @ORM\Column(name="file_contents", type="blob")
     */
    private $fileContents;



    public function getFileId()
    {
        return $this->fileId;
    }

    public function setFileId($fileId)
    {
        $this->fileId = $fileId;
    }
    
    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileType()
    {
        return $this->fileType;
    }

    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    public function getFileContents()
    {
        return $this->fileContents;
    }

    public function setFileContents($fileContents)
    {
        $this->fileContents = $fileContents;
    }
}
