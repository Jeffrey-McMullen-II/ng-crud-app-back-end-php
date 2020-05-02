<?php declare(strict_types = 1);

namespace App\Users;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Users\UserRepository")
 */
class User {
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="email", type="text")
     */
    private $email;

    /**
     * @ORM\Column(name="first_name", type="text")
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="text")
     */
    private $lastName;

    

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }
}
