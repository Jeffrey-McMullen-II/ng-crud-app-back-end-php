<?php declare(strict_types = 1);

namespace App\Core\ErrorLogs;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use App\Core\ErrorLogs\ErrorLog;

/**
 * @method ErrorLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ErrorLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ErrorLog[]    findAll()
 * @method ErrorLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ErrorLogRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ErrorLog::class);
    }

    function persist(ErrorLog $errorLog) {
        $this->_em->persist($errorLog);
        $this->_em->flush();
    }
}
