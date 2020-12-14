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
