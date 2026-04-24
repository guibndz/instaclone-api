<?php

namespace App\Http\Controllers;

use App\Services\FollowService;
use Illuminate\Http\JsonResponse;

class FollowController extends Controller
{
    protected FollowService $followService;

    public function __construct()
    {
        $this->followService = new FollowService();
    }

    public function follow(int $id): JsonResponse
    {
        $result = $this->followService->follow($id);
        return response()->json($result);
    }

    public function unfollow(int $id): JsonResponse
    {
        $result = $this->followService->unfollow($id);
        return response()->json($result);
    }

    public function followers(int $id): JsonResponse
    {
        $users = $this->followService->getFollowers($id);
        return response()->json($users);
    }

    public function following(int $id): JsonResponse
    {
        $users = $this->followService->getFollowing($id);
        return response()->json($users);
    }

    public function isFollowing(int $id): JsonResponse
    {
        $result = $this->followService->isFollowing($id);
        return response()->json($result);
    }
}