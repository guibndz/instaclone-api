<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    protected LikeService $likeService;

    public function __construct()
    {
        $this->likeService = new LikeService();
    }

    public function like(int $id): JsonResponse
    {
        $result = $this->likeService->like($id);
        return response()->json($result);
    }

    public function unlike(int $id): JsonResponse
    {
        $result = $this->likeService->unlike($id);
        return response()->json($result);
    }

    public function likes(int $id): JsonResponse
    {
        $likes = $this->likeService->getLikes($id);
        return response()->json($likes);
    }
}