<?php declare(strict_types = 1);

namespace App\Core\Logs;

use App\Core\Logs\Log;
use App\Core\Logs\LogRepository;
use App\Core\Logs\LogTypesEnum;

class LogService
{
    private LogRepository $LogRepository;

    public function __construct(LogRepository $LogRepository)
    {
        $this->LogRepository = $LogRepository;
    }

    public function logDebug(string $message)
    {
        $this->LogRepository->persist(new Log(LogTypesEnum::DEBUG, $message));
    }

    public function logInfo(string $message)
    {
        $this->LogRepository->persist(new Log(LogTypesEnum::INFO, $message));
    }

    public function logError(string $message)
    {
        $this->LogRepository->persist(new Log(LogTypesEnum::ERROR, $message));
    }
}
