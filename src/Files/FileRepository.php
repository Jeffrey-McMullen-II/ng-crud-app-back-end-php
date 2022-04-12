<?php declare(strict_types = 1);

namespace App\Files;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

use App\Core\Pagination\PaginationRequest;
use App\Core\Pagination\PaginationResponse;
use App\Core\Repositories\BaseRepository;
use App\Files\File;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }
    
    function findFileByFileName(string $fileName): ?File
    {
        $query = "SELECT file_id, file_name, file_type, file_contents " .
                 "FROM files " .
                 "WHERE file_name LIKE '%' :fileName '%' " .
                 "AND file_type IN(SELECT image_type FROM util_image_types) " .
                 "LIMIT 1";
        
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(File::class, "file");
        $mapping->addFieldResult("file", "file_id", "fileId");
        $mapping->addFieldResult("file", "file_name", "fileName");
        $mapping->addFieldResult("file", "file_type", "fileType");
        $mapping->addFieldResult("file", "file_contents", "fileContents");
        
        $result = $this->_em->createNativeQuery($query, $mapping)
                ->setParameter("fileName", $fileName)
                ->getResult();
        
        return ($result !== null && count($result) > 0) ? $result[0] : null;
    }
    
    function findImageFileContentsBy(string $fileName): ?string
    {
        $conn = $this->_em->getConnection();

        $query = "SELECT file_contents AS fileContents " .
                 "FROM files " .
                 "WHERE file_name LIKE '%' :fileName '%' " .
                 "AND file_type IN(SELECT image_type FROM util_image_types) " .
                 "LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->execute(["fileName" => $fileName]);
        
        $results = $stmt->fetchAll();
        
        return ($results !== null && count($results) > 0) ? $results[0]["fileContents"] : null;
    }
    
    function findImageFilesBy(PaginationRequest $paginationRequest): PaginationResponse
    {
        $query = "SELECT file_id, file_name, file_type, file_contents " .
                 "FROM files " .
                 "WHERE file_type IN(SELECT image_type FROM util_image_types) " .
                 "LIMIT " . $paginationRequest->getFirst() . ", " . $paginationRequest->getRows();
        
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(File::class, "file");
        $mapping->addFieldResult("file", "file_id", "fileId");
        $mapping->addFieldResult("file", "file_name", "fileName");
        $mapping->addFieldResult("file", "file_type", "fileType");
        $mapping->addFieldResult("file", "file_contents", "fileContents");
        
        $files = $this->_em->createNativeQuery($query, $mapping)->getResult();
        
        return new PaginationResponse($this->findImageFileCount(), $files);
    }
    
    private function findImageFileCount(): int
    {
        $conn = $this->_em->getConnection();

        $query = "SELECT COUNT(*) AS fileCount FROM files WHERE file_type IN(SELECT image_type FROM util_image_types)";
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        $fileCount = $results[0]["fileCount"];
        
        return intval($fileCount);
    }
}
