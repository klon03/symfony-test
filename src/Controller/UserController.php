<?php

namespace App\Controller;

use App\Formatter\ApiResponseFormatter;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    public function __construct (
        private ApiResponseFormatter $apiResponseFormatter,
        private UserService $userService
    )
    {
    }

    #[Route('/api/users/me', name: 'getMe', methods: ["GET"])]
    #[IsGranted("ROLE_USER")]
    public function getMe(): JsonResponse
    {
        $user = $this->getUser();
        return $this->apiResponseFormatter->success($this->userService->getUserData($user));
    }

    #[Route('/api/users/one/{id}', name: 'getOne', methods: ["GET"])]
    #[IsGranted("ROLE_SHOW_USER")]
    public function getOne(int $id): JsonResponse
    {
        $user = $this->userService->getOne($id);
        if ($user) {
            $data = $this->userService->getUserData($user);
            return $this->apiResponseFormatter->success($data);
        } else {
            return $this->apiResponseFormatter->error("User not found");
        }
    }

    #[Route('/api/users/all', name: 'getAll', methods: ["GET"])]
    #[IsGranted("ROLE_SHOW_USERS")]
    public function getAll(): JsonResponse
    {
        $users = $this->userService->getAll();
        $data = array_map([$this->userService, 'getUserData'], $users);

        return $this->apiResponseFormatter->success($data);
    }

    #[Route('/api/users/add', name: 'addUser', methods: ["POST"])]
    #[IsGranted("ROLE_ADD_USER")]
    public function addUser(Request $request): JsonResponse
    {
        $data = $request->toArray();

        try {
            $result = $this->userService->addUser($data);
            return $this->apiResponseFormatter->success($result);
        } catch (\Exception $e) {
            return $this->apiResponseFormatter->error($e->getMessage());
        }
    }


    #[Route('/api/users/delete/{id}', name: 'removeUser', methods: ["DELETE"])]
    #[IsGranted("ROLE_DELETE_USER")]
    public function removeUser(int $id): JsonResponse
    {
        $this->userService->removeUser($id);
        return $this->apiResponseFormatter->success([]);
    }


    #[Route('/api/users/update/{id}', name: 'updateUser', methods: ["PUT"])]
    #[IsGranted("ROLE_UPDATE_USER")]
    public function updateUser(int $id, Request $request): JsonResponse
    {
        $data = $request->toArray();
        $this->userService->updateUser($id, $data);

        return $this->apiResponseFormatter->success([]);
    }

}
