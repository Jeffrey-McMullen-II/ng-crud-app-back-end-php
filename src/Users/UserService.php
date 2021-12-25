<?php declare(strict_types = 1);

namespace App\Users;

use App\Core\Logs\LogService;
use App\Users\User;
use App\Users\UserRepository;

class UserService
{
    private UserRepository $userRepository;
    private LogService $logService;

    public function __construct(UserRepository $userRepository, LogService $logService)
    {
        $this->userRepository = $userRepository;
        $this->logService = $logService;
    }

    function findUserBy(int $userId): User
    {
        return $this->userRepository->findUserBy($userId);
    }

    function getCountOfUsers(): int
    {
        return $this->userRepository->getCountOfUsers();
    }

    function findAllUsersOrderByFirstName(): array
    {
        return $this->userRepository->findAll();
    }

    function createUser(User $user)
    {
        $this->userRepository->create($user);

        $userCount = $this->getCountOfUsers();

        if ($userCount > 99)
        {
            $oldestUser = $this->userRepository->findOldestUser();
            $this->deleteUserById($oldestUser->getId());
        }
    }

    function updateUser(User $user)
    {
        $this->userRepository->update($user);
    }

    function deleteUserBy(int $userId): User
    {        
        $user = $this->findUserBy($userId);
        
        if ($user !== null)
        {
            $this->logService->logInfo("Deleting user with id: " . $userId);
            $this->userRepository->delete($user);
        }
        
        return $user;
    }
}
