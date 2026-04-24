<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FollowService
{
    public function follow(int $targetUserId): array
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $targetUserId) {
            throw ValidationException::withMessages([
                'follow' => ['Você não pode seguir a si mesmo.'],
            ]);
        }

        $targetUser = User::findOrFail($targetUserId);
        
        // syncWithoutDetaching adiciona o vínculo sem apagar os outros e não duplica
        $currentUser->following()->syncWithoutDetaching([$targetUserId]);

        return ['message' => "Você agora está seguindo {$targetUser->username}"];
    }

    public function unfollow(int $targetUserId): array
    {
        $currentUser = Auth::user();
        $targetUser = User::findOrFail($targetUserId);

        $currentUser->following()->detach($targetUserId);

        return ['message' => "Você deixou de seguir {$targetUser->username}"];
    }

    public function getFollowers(int $userId)
    {
        $user = User::findOrFail($userId);
        return $user->followers()->select('users.id', 'name', 'username', 'avatar_url')->get();
    }

    public function getFollowing(int $userId)
    {
        $user = User::findOrFail($userId);
        return $user->following()->select('users.id', 'name', 'username', 'avatar_url')->get();
    }

    public function isFollowing(int $targetUserId): array
    {
        $currentUser = Auth::user();
        $isFollowing = $currentUser->following()->where('following_id', $targetUserId)->exists();

        return ['is_following' => $isFollowing];
    }
}