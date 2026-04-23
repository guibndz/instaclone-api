<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function findByUsername(string $username): User
    {
        return User::where('username', $username)->firstOrFail();
    }

    public function update(Request $request): User
    {
        $user = $request->user();

        $data = request->validate([
            'name'     => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,'.$user->id.'|alpha_dash',
            'bio'      => 'sometimes|nullable|string|max:500',
        ]);

        $user->update($data);

        return $user->fresh();
    }

    public function updateAvatar(Request $request): User
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = request->user();

        if ($user->avatar_url){
            Storage::disk('public')->delete($user->avatar_url);
        }

        $path = request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar_url' => $path]);

        return $user->fresh();
    }

    public function search(string $query): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();
    }
}