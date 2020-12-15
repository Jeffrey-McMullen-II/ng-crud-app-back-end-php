<?php declare(strict_types = 1);

namespace App\Core\Logs;

use DateTime;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="logs")
 * @ORM\Entity(repositoryClass="App\Core\Logs\LogRepository")
 */
class Log
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="log_id", type="integer")
     */
    private ?int $logId;

    /**
     * @ORM\Column(name="log_type_id", type="integer")
     */
    private int $logTypeId;

    /**
     * @ORM\Column(name="log_message", type="text")
     */
    private string $logMessage;
    
    /**
     * @ORM\Column(name="log_date", type="datetime")
     */
    private DateTime $logDate;



    public function __construct(int $logTypeId, string $logMessage)
    {
        $this->logTypeId = $logTypeId;
        $this->logMessage = $logMessage;
        $this->logDate = new DateTime();
    }



    public function getLogId(): int
    {
        return $this->logId;
    }

    public function setLogId(int $logId)
    {
        $this->logId = $logId;
    }

    public function getLogTypeId(): int
    {
        return $this->logTypeId;
    }

    public function setLogTypeId(int $logTypeId)
    {
        $this->logTypeId = $logTypeId;
    }
    
    public function getLogMessage(): string
    {
        return $this->logMessage;
    }

    public function setLogMessage(string $logMessage)
    {
        $this->logMessage = $logMessage;
    }
    
    public function getLogDate(): DateTime
    {
        return $this->logDate;
    }
    
    public function setLogDate(DateTime $logDate)
    {
        $this->logDate = $logDate;
    }
}
