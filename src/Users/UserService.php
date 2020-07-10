<?php declare(strict_types = 1);

namespace App\Users;

use App\Core\Logs\LogService;
use App\Users\User;
use App\Users\UserRepository;

class UserService {

    private UserRepository $userRepository;
    private LogService $logService;

    public function __construct(UserRepository $userRepository, LogService $logService) {
        $this->userRepository = $userRepository;
        $this->logService = $logService;
    }

    function findUserById(int $id): User {
        return $this->userRepository->findUserByUserId($id);
    }

    function getCountOfUsers(): int {
        return $this->userRepository->getCountOfUsers();
    }

    function findAllUsersOrderByFirstName(): array {
        return $this->userRepository->findAllWithLimit();
    }

    function createUser(User $user) {
        $this->userRepository->persist($user);

        $userCount = $this->getCountOfUsers();

        if ($userCount > 99) {
            $oldestUser = $this->userRepository->findOldestUser();
            $this->deleteUserById($oldestUser->getId());
        }
    }

    function updateUser(User $user) {
        $this->userRepository->merge($user);
    }

    function deleteUserById(int $id): User {
        $this->logService->logInfo("Deleting user with id: " . $id);
        
        $user = $this->findUserById($id);
        $this->userRepository->remove($user);
        return $user;
    }
}
