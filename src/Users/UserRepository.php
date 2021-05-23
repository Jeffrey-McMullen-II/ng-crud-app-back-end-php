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

    function findUserByUserId(int $userId): User
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
        $mapping->addFieldResult("u", "user_first_name", "userFirstName");
        $mapping->addFieldResult("u", "user_last_name", "userLastName");
        $mapping->addFieldResult("u", "user_email", "userEmail");
        
        return $this->_em->createNativeQuery("SELECT * FROM users ORDER BY user_id ASC LIMIT 100", $mapping)->getResult();
    }

    function findAllByFirstNameNativeQuery(string $userFirstName): array
    {
        $mapping = new ResultSetMapping();
        $mapping->addEntityResult(User::class, "u");
        $mapping->addFieldResult("u", "user_id", "userId");
        $mapping->addFieldResult("u", "user_first_name", "userFirstName");
        $mapping->addFieldResult("u", "user_last_name", "userLastName");
        $mapping->addFieldResult("u", "user_email", "userEmail");
        
        $query = $this->_em->createNativeQuery
        (
            "SELECT * FROM users " . 
            "WHERE user_first_name = :userFirstName " .
            "ORDER BY user_id ASC", $mapping
        );

        $query->setParameter("userFirstName", $userFirstName);
        
        return $query->getResult();
    }

    function findAllByFirstNameDQL(string $userFirstName): array
    {
        $query = $this->_em->createQuery
        (
            "SELECT u FROM " . User::class . " u " .
            "WHERE u.userFirstName = :userFirstName " .
            "ORDER BY u.user_id DESC"
        );

        $query->setParameter("userFirstName", $userFirstName);
        
        return $query->getResult();
    }

    function findAllByFirstNameSQL(string $userFirstName): array
    {
        $conn = $this->_em->getConnection();

        $sql = "SELECT u.user_id, u.user_first_name AS firstName, u.user_last_name AS lastName, u.user_email
                FROM Users u
                WHERE u.user_first_name = :userFirstName
                ORDER BY u.user_first_name ASC";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute(["userFirstName" => $userFirstName]);
    
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
        $mapping->addFieldResult("u", "user_first_name", "userFirstName");
        $mapping->addFieldResult("u", "user_last_name", "userLastName");
        $mapping->addFieldResult("u", "user_email", "userEmail");
        
        $query = $this->_em->createNativeQuery
        (
            "SELECT * FROM users 
             ORDER BY user_id ASC
             LIMIT 1", $mapping
        );

        return $query->getResult()[0];
    }

    function persist(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    function merge(User $user)
    {
        $this->_em->merge($user);
        $this->_em->flush();
    }

    function remove(User $user)
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
