<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    #[OA\Post(
        path: '/posts',
        summary: 'Cria um novo post',
        security: [['bearerAuth' => []]],
        tags: ['Posts'],
        responses: [new OA\Response(response: 201, description: 'Post criado')]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['image'],
                properties: [
                    new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Imagem do post (jpg, png, webp)'),
                    new OA\Property(property: 'caption', type: 'string', description: 'Legenda do post')
                ]
            )
        )
    )]
    public function store(Request $request): JsonResponse
    {
        $post = $this->postService->create($request);
        return response()->json($post, 201);
    }

    #[OA\Get(
        path: '/posts/{id}',
        summary: 'Retorna um post',
        security: [['bearerAuth' => []]],
        tags: ['Posts'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Post')]
    )]
    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPost($id);
        return response()->json($post);
    }

    #[OA\Put(
        path: '/posts/{id}',
        summary: 'Atualiza a legenda do post',
        security: [['bearerAuth' => []]],
        tags: ['Posts'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Post atualizado')]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'caption', type: 'string', example: 'Nova legenda para o post editado!')
            ]
        )
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $post = $this->postService->update($id, $request);
        return response()->json($post);
    }

    #[OA\Delete(
        path: '/posts/{id}',
        summary: 'Deleta o post',
        security: [['bearerAuth' => []]],
        tags: ['Posts'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Post deletado')]
    )]
    public function destroy(int $id): JsonResponse
    {
        $result = $this->postService->delete($id);
        return response()->json($result);
    }

    #[OA\Get(
        path: '/users/{id}/posts',
        summary: 'Lista os posts de um usuário',
        security: [['bearerAuth' => []]],
        tags: ['Posts'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Posts do usuário')]
    )]
    public function userPosts(int $userId): JsonResponse
    {
        $posts = $this->postService->getUserPosts($userId);
        return response()->json($posts);
    }
}