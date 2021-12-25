<?php declare(strict_types = 1);

namespace App\Core\Repositories;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $className)
    {
        parent::__construct($registry, $className);
    }
    
    function create(object $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    function update(object $entity)
    {
        $this->_em->merge($entity);
        $this->_em->flush();
    }

    function delete(object $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
