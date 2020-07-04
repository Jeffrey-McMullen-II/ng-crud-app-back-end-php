<?php declare(strict_types = 1);

namespace App\Core\Logs;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use App\Core\Logs\Log;

/**
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Log::class);
    }

    function persist(Log $Log) {
        $this->_em->persist($Log);
        $this->_em->flush();
    }
}
