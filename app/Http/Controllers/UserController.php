<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;
    
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function show(string $username): JsonResponse
    {
        $user = $this->userService->findByUsername($username);

        return response()->json($user);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $this->userService->update($request);

        return response()->json($user);
    }

    public function updateAvatar(Request $request): JsonResponse
    {
        $user = $this->userService->updateAvatar($request);

        return response()->json($user);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $users = $this->userService->search($query['q']);

        return response()->json($users);
    }
}