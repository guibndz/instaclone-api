<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct()
    {
        $this->commentService = new CommentService();
    }

    public function store(Request $request, int $postId): JsonResponse
    {
        $comment = $this->commentService->create($postId, $request);
        return response()->json($comment, 201);
    }

    public function index(int $postId): JsonResponse
    {
        $comments = $this->commentService->getPostComments($postId);
        return response()->json($comments);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $comment = $this->commentService->update($id, $request);
        return response()->json($comment);
    }

    public function destroy(int $id): JsonResponse
    {
        $result = $this->commentService->delete($id);
        return response()->json($result);
    }
}