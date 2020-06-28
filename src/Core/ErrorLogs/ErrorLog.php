<?php declare(strict_types = 1);

namespace App\Core\ErrorLogs;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="error_logs")
 * @ORM\Entity(repositoryClass="App\Core\ErrorLogs\ErrorLogRepository")
 */
class ErrorLog {
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(name="message", type="text")
     */
    private string $message;

    public function __construct(string $message) {
        $this->message = $message;
    }
    

    
    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage(string $message) {
        $this->message = $message;
    }
}
