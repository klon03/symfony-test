<?php

namespace App\Controller;

use App\Formatter\ApiResponseFormatter;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public function __construct (
        private UserRepository $userRepository,
        private ApiResponseFormatter $apiResponseFormatter,
    )
    {
    }


    #[Route('/api/users/show', name: 'showUser',methods: ["GET"])]
    public function showUser(): JsonResponse
    {
        $user = $this->getUser();
        $data = [
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "roles" => $user->getRoles(),
        ];


        return $this->apiResponseFormatter->success($data);
    }
}
