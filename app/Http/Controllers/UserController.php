<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    protected UserService $userService;
    
    public function __construct()
    {
        $this->userService = new UserService();
    }

    #[OA\Get(
        path: '/users/{username}',
        summary: 'Busca um usuário pelo username',
        security: [['bearerAuth' => []]],
        tags: ['Usuários'],
        parameters: [
            new OA\Parameter(name: 'username', in: 'path', required: true, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Usuário encontrado'),
            new OA\Response(response: 404, description: 'Usuário não encontrado')
        ]
    )]
    public function show(string $username): JsonResponse
    {
        $user = $this->userService->findByUsername($username);

        return response()->json($user);
    }

    #[OA\Put(
        path: '/users/me',
        summary: 'Atualiza o perfil do usuário logado',
        security: [['bearerAuth' => []]],
        tags: ['Usuários'],
        responses: [
            new OA\Response(response: 200, description: 'Perfil atualizado')
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Guilherme Bondezan'),
                new OA\Property(property: 'username', type: 'string', example: 'gui_bondezan'),
                new OA\Property(property: 'bio', type: 'string', example: 'Desenvolvedor PHP & Laravel')
            ]
        )
    )]
    public function update(Request $request): JsonResponse
    {
        $user = $this->userService->update($request);

        return response()->json($user);
    }

    #[OA\Post(
        path: '/users/me/avatar',
        summary: 'Atualiza a foto de perfil do usuário logado',
        security: [['bearerAuth' => []]],
        tags: ['Usuários'],
        responses: [
            new OA\Response(response: 200, description: 'Avatar atualizado')
        ]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['avatar'],
                properties: [
                    new OA\Property(property: 'avatar', type: 'string', format: 'binary', description: 'Imagem de perfil (jpg, png, webp)')
                ]
            )
        )
    )]
    public function updateAvatar(Request $request): JsonResponse
    {
        $user = $this->userService->updateAvatar($request);

        return response()->json($user);
    }

    #[OA\Get(
        path: '/users/search',
        summary: 'Pesquisa por usuários',
        security: [['bearerAuth' => []]],
        tags: ['Usuários'],
        parameters: [
            new OA\Parameter(name: 'q', in: 'query', required: true, schema: new OA\Schema(type: 'string'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Lista de usuários encontrados')
        ]
    )]
    public function search(Request $request): JsonResponse
    {
        $query = $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $users = $this->userService->search($query['q']);

        return response()->json($users);
    }
}