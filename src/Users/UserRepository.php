<?php declare(strict_types = 1);

namespace App\Users;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

use App\Users\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    function findUserBy(int $userId): User
    {
        $query = $this->_em->createQuery("SELECT u FROM " . User::class . " u " . "WHERE u.user_id = :userId");
        $query->setParameter("userId", $userId); 
        return $query->getResult()[0];
    }

    function findAllWithLimit(): array
    {
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(User::class, "u");
        $mapping->addFieldResult("u", "user_id", "userId");
        $mapping->addFieldResult("u", "first_name", "firstName");
        $mapping->addFieldResult("u", "last_name", "lastName");
        $mapping->addFieldResult("u", "email", "email");
        
        return $this->_em->createNativeQuery("SELECT * FROM users ORDER BY user_id ASC LIMIT 100", $mapping)->getResult();
    }

    function findAllByFirstNameNativeQuery(string $firstName): array
    {
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(User::class, "u");
        $mapping->addFieldResult("u", "user_id", "userId");
        $mapping->addFieldResult("u", "first_name", "firstName");
        $mapping->addFieldResult("u", "last_name", "lastName");
        $mapping->addFieldResult("u", "email", "email");
        
        $query = $this->_em->createNativeQuery
        (
            "SELECT * FROM users " . 
            "WHERE first_name = :firstName " .
            "ORDER BY user_id ASC", $mapping
        );

        $query->setParameter("firstName", $firstName);
        
        return $query->getResult();
    }

    function findAllByFirstNameDQL(string $firstName): array
    {
        $query = $this->_em->createQuery
        (
            "SELECT u FROM " . User::class . " u " .
            "WHERE u.firstName = :firstName " .
            "ORDER BY u.user_id DESC"
        );

        $query->setParameter("firstName", $firstName);
        
        return $query->getResult();
    }

    function findAllByFirstNameSQL(string $firstName): array
    {
        $conn = $this->_em->getConnection();

        $sql = "SELECT u.user_id, u.first_name AS firstName, u.last_name AS lastName, u.email
                FROM Users u
                WHERE u.first_name = :firstName
                ORDER BY firstName ASC";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute(["firstName" => $firstName]);
    
        return $stmt->fetchAll();
    }

    function getCountOfUsers(): int
    {
        $conn = $this->_em->getConnection();

        $sql = "SELECT COUNT(*) AS userCount FROM users";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll();
        $userCount = $results[0]["userCount"];
        return intval($userCount);
    }

    function findOldestUser(): User
    {
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(User::class, "u");
        $mapping->addFieldResult("u", "user_id", "userId");
        $mapping->addFieldResult("u", "first_name", "firstName");
        $mapping->addFieldResult("u", "last_name", "lastName");
        $mapping->addFieldResult("u", "email", "email");
        
        $query = $this->_em->createNativeQuery
        (
            "SELECT * FROM users 
             ORDER BY user_id ASC
             LIMIT 1", $mapping
        );

        return $query->getResult()[0];
    }
}
