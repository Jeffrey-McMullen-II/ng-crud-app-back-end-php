<?php declare(strict_types = 1);

namespace App\Users;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Core\BaseController;
use App\Users\UserService;
use App\Users\User;

/**
 * @Route("/api/users")
 */
class UserController extends BaseController {

    private UserService $userService;

    public function __construct(UserService $userService) {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * @Route("/first-name/ascending")
     * @Method("GET")
     */
    function findAllUsersOrderByFirstName() {
        $users = $this->userService->findAllUsersOrderByFirstName();
        
        return new Response($this->objToJson($users));
    }
    
    /**
     * @Route
     * @Method("POST")
     */
    function createUser(Request $request) {
        $user = $this->jsonToObj($request->getContent(), User::class);
        
        $this->userService->createUser($user);
        
        return new Response($this->objToJson($user));
    }

    /**
     * @Route
     * @Method("PUT")
     */
    function updateUser(Request $request) {
        $user = $this->jsonToObj($request->getContent(), User::class);

        $this->userService->updateUser($user);
 
        return new Response($this->objToJson($user));
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    function deleteUserById(int $id) {
        $user = $this->userService->deleteUserById($id);

        return new Response($this->objToJson($user));
    }
}
