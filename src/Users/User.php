<?php declare(strict_types = 1);

namespace App\Users;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Users\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="user_id", type="integer")
     */
    private ?int $userId;

    /**
     * @ORM\Column(name="user_email", type="text")
     */
    private string $userEmail;

    /**
     * @ORM\Column(name="user_first_name", type="text")
     */
    private string $userFirstName;

    /**
     * @ORM\Column(name="user_last_name", type="text")
     */
    private string $userLastName;

    

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function getUserFirstName(): string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(string $userFirstName)
    {
        $this->userFirstName = $userFirstName;
    }

    public function getUserLastName(): string
    {
        return $this->userLastName;
    }

    public function setUserLastName(string $userLastName)
    {
        $this->userLastName = $userLastName;
    }
}
