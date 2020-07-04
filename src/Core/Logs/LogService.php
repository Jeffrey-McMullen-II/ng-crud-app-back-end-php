<?php declare(strict_types = 1);

namespace App\Core\Logs;

use App\Core\Logs\LogRepository;
use App\Core\Logs\Log;

class LogService {

    private LogRepository $LogRepository;

    public function __construct(LogRepository $LogRepository) {
        $this->LogRepository = $LogRepository;
    }
    
    public function saveLog(int $logTypeId, string $message) {
        $this->LogRepository->persist(new Log($logTypeId, $message));
    }
    
    /* TODO implment this
     * use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
     * throw new BadRequestHttpException("Not allowed to execute");
     */
}
