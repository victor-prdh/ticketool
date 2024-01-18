<?php

namespace App\Controller\Api;

use App\Service\User\Register;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api', 'api_')]
final class RegistrationController
{
    #[Route('/register', name: 'register', methods:['POST'])]
    public function index(Request $request, Register $register): JsonResponse
    {
        try {
            $user = $register->fromApi($request->toArray());
        } catch (\Throwable $th) {
            throw new BadRequestException($th);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'User created', 
            'data' => [
                'id' => $user->getId(),
                'userIdentifier' => $user->getUserIdentifier()
            ]
        ]);
    }
}
