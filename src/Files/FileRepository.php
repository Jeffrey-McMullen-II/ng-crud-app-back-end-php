<?php declare(strict_types = 1);

namespace App\Files;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

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
    
    function findFileCount(): int
    {
        $conn = $this->_em->getConnection();

        $sql = 'SELECT COUNT(*) AS fileCount FROM files';
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        $fileCount = $results[0]['fileCount'];
        return intval($fileCount);
    }
    
    function findFileByName($fileName): File
    {
        $conn = $this->_em->getConnection();

        $sql = 'SELECT file_name, file_contents AS fileContents FROM files WHERE file_name = :fileName';
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['fileName' => $fileName]);
        
        $results = $stmt->fetchAll();
        
        if ($results !== null && count($results) > 0)
        {
            return $results[0]['fileContents'];
        }
        
        return null;
    }
    
    function findFilesBy(int $offset, int $rows): array
    {
        $query = 'SELECT file_id, file_name, file_type, file_contents ' .
                 'FROM files ' .
                 'LIMIT ' . $offset . ', ' . $rows;
        
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(File::class, 'file');
        $mapping->addFieldResult('file', 'file_id', 'fileId');
        $mapping->addFieldResult('file', 'file_name', 'fileName');
        $mapping->addFieldResult('file', 'file_type', 'fileType');
        $mapping->addFieldResult('file', 'file_contents', 'fileContents');
        
        return $this->_em->createNativeQuery($query, $mapping)->getResult();
    }

    function persist($file)
    {
        $this->_em->persist($file);
        $this->_em->flush();
    }

    function merge($file)
    {
        $this->_em->merge($file);
        $this->_em->flush();
    }

    function remove($file)
    {
        $this->_em->remove($file);
        $this->_em->flush();
    }
}
