<?php declare(strict_types = 1);

namespace App\Files;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

use App\Core\Pagination\PaginationResponse;
use App\Core\Pagination\PaginationRequest;
use App\Files\File;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }
    
    function findFileContentsForFileByName(string $fileName)
    {
        $conn = $this->_em->getConnection();

        $query = "SELECT file_contents AS fileContents FROM files WHERE file_name = :fileName";
        
        $stmt = $conn->prepare($query);
        $stmt->execute(["fileName" => $fileName]);
        
        $results = $stmt->fetchAll();
        
        return ($results !== null && count($results) > 0) ? $results[0]["fileContents"] : null;
    }
    
    function findFilesBy(PaginationRequest $paginationRequest): PaginationResponse
    {
        $query = "SELECT file_id, file_name, file_type, file_contents " .
                 "FROM files " .
                 "LIMIT " . $paginationRequest->getFirst() . ", " . $paginationRequest->getRows();
        
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(File::class, "file");
        $mapping->addFieldResult("file", "file_id", "fileId");
        $mapping->addFieldResult("file", "file_name", "fileName");
        $mapping->addFieldResult("file", "file_type", "fileType");
        $mapping->addFieldResult("file", "file_contents", "fileContents");
        
        $files = $this->_em->createNativeQuery($query, $mapping)->getResult();
        
        return new PaginationResponse($this->findFileCount(), $files);
    }
    
    private function findFileCount(): int
    {
        $conn = $this->_em->getConnection();

        $query = "SELECT COUNT(*) AS fileCount FROM files";
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        $fileCount = $results[0]["fileCount"];
        return intval($fileCount);
    }

    function persist(File $file)
    {
        $this->_em->persist($file);
        $this->_em->flush();
    }

    function merge(File $file)
    {
        $this->_em->merge($file);
        $this->_em->flush();
    }

    function remove(File $file)
    {
        $this->_em->remove($file);
        $this->_em->flush();
    }
}
