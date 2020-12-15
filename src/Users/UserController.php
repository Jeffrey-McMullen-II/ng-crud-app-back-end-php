<?php declare(strict_types = 1);

namespace App\Users;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Core\Controllers\BaseController;
use App\Core\JsonMappers\JsonMapper;
use App\Users\User;
use App\Users\UserService;

/**
 * @Route("/api/users")
 */
class UserController extends BaseController
{
    private UserService $userService;

    public function __construct(JsonMapper $jsonMapper, UserService $userService)
    {
        parent::__construct($jsonMapper);
        
        $this->userService = $userService;
    }

    /**
     * @Route("/first-name/ascending")
     * @Method("GET")
     */
    function findAllUsersOrderByFirstName()
    {
        $users = $this->userService->findAllUsersOrderByFirstName();
        
        return new Response($this->toJson($users));
    }
    
    /**
     * @Route
     * @Method("POST")
     */
    function createUser(Request $request)
    {
        $user = $this->toObject($request->getContent(), User::class);
        
        $this->userService->createUser($user);
        
        return new Response($this->toJson($user));
    }

    /**
     * @Route
     * @Method("PUT")
     */
    function updateUser(Request $request)
    {
        $user = $this->toObject($request->getContent(), User::class);

        $this->userService->updateUser($user);
 
        return new Response($this->toJson($user));
    }

    /**
     * @Route("/{userId}")
     * @Method("DELETE")
     */
    function deleteUserByUserId(int $userId)
    {
        $user = $this->userService->deleteUserByUserId($userId);

        return new Response($this->toJson($user));
    }
}
