<?php declare(strict_types = 1);

namespace App\Core\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Core\Logs\LogService;

class ExceptionService {

    private LogService $logService;

    public function __construct(LogService $logService) {
        $this->logService = $logService;
    }
    
    public function throwBadRequestHttpException(string $message) {
        throw new BadRequestHttpException($message);
    }
    
    public function logAndThrowBadRequestHttpException(string $message) {
        $this->logService->logError("BadRequestHttpException: " . $message);
        throw new BadRequestHttpException($message);
    }
}
