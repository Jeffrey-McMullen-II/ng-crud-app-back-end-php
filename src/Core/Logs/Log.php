<?php declare(strict_types = 1);

namespace App\Core\Logs;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="logs")
 * @ORM\Entity(repositoryClass="App\Core\Logs\LogRepository")
 */
class Log {
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private ?int $id;
    
    /**
     * @ORM\Column(name="log_type_id", type="integer")
     */
    private int $logTypeId;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private string $description;
    
    /**
     * @ORM\Column(name="log_date", type="datetime")
     */
    private ?DateTime $logDate;
    
    
    
    public function __construct(int $logTypeId, string $description) {
        $this->logTypeId = $logTypeId;
        $this->description = $description;
    }
    

    
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }
    
    public function getLogTypeId(): int {
        return $this->logTypeId;
    }
    
    public function setLogTypeId(int $logTypeId) {
        $this->logTypeId = $logTypeId;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDscription(string $description) {
        $this->description = $description;
    }
    
    public function getLogDate(): ?DateTime {
        return $this->logDate;
    }

    public function setLogDate(DateTime $logDate) {
        $this->logDate = $logDate;
    }
}
