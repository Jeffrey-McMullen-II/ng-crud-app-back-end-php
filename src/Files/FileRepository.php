<?php

namespace App\Files;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
    
    function findFileCount()
    {        
        $conn = $this->_em->getConnection();

        $sql = 'SELECT COUNT(*) AS fileCount FROM files';
                
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        $results = $stmt->fetchAll();
        $fileCount = $results[0]['fileCount'];
        return intval($fileCount);
    }
    
    function findFilesBy(int $limit, int $offset)
    {
        $conn = $this->_em->getConnection();

        $sql = 'SELECT * FROM files LIMIT ' . $limit . ', ' . $offset;
                
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        return $stmt->fetchAll();
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
