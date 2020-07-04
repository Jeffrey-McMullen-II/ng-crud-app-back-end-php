<?php declare(strict_types = 1);

namespace App\Core\ErrorLogs;

use App\Core\ErrorLogs\ErrorLogRepository;
use App\Core\ErrorLogs\ErrorLog;

class ErrorLogService {

    private ErrorLogRepository $errorLogRepository;

    public function __construct(ErrorLogRepository $errorLogRepository) {
        $this->errorLogRepository = $errorLogRepository;
    }
    
    public function logError(string $message) {
        $this->errorLogRepository->persist(new ErrorLog($message));
    }
    
    /* TODO implment this
     * use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
     * throw new BadRequestHttpException("Not allowed to execute");
     */
}
