<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    #[OA\Post(
        path: '/posts/{postId}/comments',
        summary: 'Comenta em um post',
        security: [['bearerAuth' => []]],
        tags: ['Comentários'],
        parameters: [new OA\Parameter(name: 'postId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 201, description: 'Comentário criado')]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['content'],
            properties: [
                new OA\Property(property: 'content', type: 'string', example: 'Muito legal a foto!')
            ]
        )
    )]
    public function store(Request $request, int $postId): JsonResponse
    {
        $comment = $this->commentService->create($postId, $request);
        return response()->json($comment, 201);
    }

    #[OA\Get(
        path: '/posts/{postId}/comments',
        summary: 'Lista os comentários de um post',
        security: [['bearerAuth' => []]],
        tags: ['Comentários'],
        parameters: [new OA\Parameter(name: 'postId', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Lista de comentários')]
    )]
    public function index(int $postId): JsonResponse
    {
        $comments = $this->commentService->getPostComments($postId);
        return response()->json($comments);
    }

    #[OA\Put(
        path: '/comments/{id}',
        summary: 'Atualiza um comentário',
        security: [['bearerAuth' => []]],
        tags: ['Comentários'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Comentário atualizado')]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['content'],
            properties: [
                new OA\Property(property: 'content', type: 'string', example: 'Corrigindo meu comentário...')
            ]
        )
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $comment = $this->commentService->update($id, $request);
        return response()->json($comment);
    }

    #[OA\Delete(
        path: '/comments/{id}',
        summary: 'Deleta um comentário',
        security: [['bearerAuth' => []]],
        tags: ['Comentários'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Comentário deletado')]
    )]
    public function destroy(int $id): JsonResponse
    {
        $result = $this->commentService->delete($id);
        return response()->json($result);
    }
}