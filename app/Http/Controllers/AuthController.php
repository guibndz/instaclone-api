<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    #[OA\Post(
        path: '/auth/register',
        summary: 'Registra um novo usuário',
        tags: ['Autenticação'],
        responses: [
            new OA\Response(response: 201, description: 'Usuário registrado com sucesso'),
            new OA\Response(response: 422, description: 'Erro de validação')
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['name', 'username', 'email', 'password', 'password_confirmation'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Guilherme Bondezan'),
                new OA\Property(property: 'username', type: 'string', example: 'gui_bondezan'),
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'gui@email.com'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'senha123'),
                new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'senha123')
            ]
        )
    )]
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = $this->authService->register($data);

        return response()->json($result, 201);
    }

    #[OA\Post(
        path: '/auth/login',
        summary: 'Realiza o login na aplicação',
        description: 'Recebe as credenciais do usuário e retorna o Token Bearer.',
        tags: ['Autenticação']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', format: 'email', example: 'gui@email.com'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: '123456')
            ]
        )
    )]
    #[OA\Response(response: 200, description: 'Login realizado com sucesso')]
    #[OA\Response(response: 401, description: 'Credenciais inválidas')]
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($data);

        return response()->json($result);
    }

    #[OA\Post(
        path: '/auth/logout',
        summary: 'Desloga o usuário atual',
        security: [['bearerAuth' => []]],
        tags: ['Autenticação'],
        responses: [
            new OA\Response(response: 200, description: 'Logout realizado com sucesso')
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request);

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }

    #[OA\Get(
        path: '/auth/me',
        summary: 'Retorna os dados do usuário autenticado',
        security: [['bearerAuth' => []]],
        tags: ['Autenticação'],
        responses: [
            new OA\Response(response: 200, description: 'Dados do usuário')
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return response()->json($this->authService->me($request));
    }
}