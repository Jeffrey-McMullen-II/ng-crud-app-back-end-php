<?php declare(strict_types = 1);

namespace App\Users;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

use App\Users\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, User::class);
    }

    function findUserByUserId(int $id): User {
        $query = $this->_em->createQuery('SELECT u FROM ' . User::class . ' u ' . 'WHERE u.id = :id');
        $query->setParameter('id', $id); 
        return $query->getResult()[0];
    }

    function findAllWithLimit(): array {
        $mapping = new ResultSetMapping;
        $mapping->addEntityResult(User::class, 'u');
        $mapping->addFieldResult('u', 'id', 'id');
        $mapping->addFieldResult('u', 'first_name', 'firstName');
        $mapping->addFieldResult('u', 'last_name', 'lastName');
        $mapping->addFieldResult('u', 'email', 'email');
        
        return $this->_em->createNativeQuery('SELECT * FROM users ORDER BY id ASC LIMIT 100', $mapping)->getResult();
    }

    function findAllByFirstNameNativeQuery(string $name): array {
        $mapping = new ResultSetMapping;
        $mapping->addEntityResult(User::class, 'u');
        $mapping->addFieldResult('u', 'id', 'id');
        $mapping->addFieldResult('u', 'first_name', 'firstName');
        $mapping->addFieldResult('u', 'last_name', 'lastName');
        $mapping->addFieldResult('u', 'email', 'email');
        
        $query = $this->_em->createNativeQuery(
            'SELECT * FROM users ' . 
            'WHERE first_name = :firstName ' .
            'ORDER BY id ASC', $mapping);
        $query->setParameter('firstName', $name);
        
        return $query->getResult();
    }

    function findAllByFirstNameDQL(string $name): array {
        $query = $this->_em->createQuery(
            'SELECT u FROM ' . User::class . ' u ' .
            'WHERE u.firstName = :firstName ' .
            'ORDER BY u.id DESC');
        $query->setParameter('firstName', $name);
        
        return $query->getResult();
    }

    function findAllByFirstNameSQL(string $name): array {
        $conn = $this->_em->getConnection();

        $sql = 'SELECT u.id, u.first_name AS firstName, u.last_name AS lastName, u.email
                FROM Users u
                WHERE u.first_name = :firstName
                ORDER BY u.first_name ASC';
                
        $stmt = $conn->prepare($sql);
        $stmt->execute(['firstName' => $name]);
    
        return $stmt->fetchAll();
    }

    function getCountOfUsers(): int {
        $conn = $this->_em->getConnection();

        $sql = 'SELECT COUNT(*) AS userCount FROM users';
                
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        $userCount = $results[0]['userCount'];
        return intval($userCount);
    }

    function findOldestUser(): User {
        $mapping = new ResultSetMapping;
        $mapping->addEntityResult(User::class, 'u');
        $mapping->addFieldResult('u', 'id', 'id');
        $mapping->addFieldResult('u', 'first_name', 'firstName');
        $mapping->addFieldResult('u', 'last_name', 'lastName');
        $mapping->addFieldResult('u', 'email', 'email');
        
        $query = $this->_em->createNativeQuery(
            'SELECT * FROM users 
             ORDER BY id ASC
             LIMIT 1', $mapping);

        return $query->getResult()[0];
    }

    function persist(User $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    function merge(User $user) {
        $this->_em->merge($user);
        $this->_em->flush();
    }

    function remove(User $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}
