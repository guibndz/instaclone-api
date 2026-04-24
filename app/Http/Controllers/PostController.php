<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct()
    {
        $this->postService = new PostService();
    }

    public function store(Request $request): JsonResponse
    {
        $post = $this->postService->create($request);
        return response()->json($post, 201);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->postService->getPost($id);
        return response()->json($post);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $post = $this->postService->update($id, $request);
        return response()->json($post);
    }

    public function destroy(int $id): JsonResponse
    {
        $result = $this->postService->delete($id);
        return response()->json($result);
    }

    public function userPosts(int $userId): JsonResponse
    {
        $posts = $this->postService->getUserPosts($userId);
        return response()->json($posts);
    }
}