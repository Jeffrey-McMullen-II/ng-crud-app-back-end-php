<?php declare(strict_types = 1);

namespace App\Users;

use App\Users\User;
use App\Users\UserRepository;

class UserService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
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
        $user = $this->findUserById($id);
        $this->userRepository->remove($user);
        return $user;
    }
}
