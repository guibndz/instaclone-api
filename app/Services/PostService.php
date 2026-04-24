<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function create(Request $request): Post
    {
        $request->validate([
            'image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'caption' => 'nullable|string|max:1000',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        return $request->user()->posts()->create([
            'image_url' => $path,
            'caption'   => $request->caption,
        ]);
    }

    public function getPost(int $id): Post
    {
        return Post::with('user:id,name,username,avatar_url')->findOrFail($id);
    }

    public function getUserPosts(int $userId)
    {
        $user = User::findOrFail($userId);
        return $user->posts()->latest()->get();
    }

    public function update(int $id, Request $request): Post
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Você só pode editar seus próprios posts.');
        }

        $data = $request->validate([
            'caption' => 'nullable|string|max:1000',
        ]);

        $post->update($data);
        return $post;
    }

    public function delete(int $id): array
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Você só pode deletar seus próprios posts.');
        }

        if ($post->image_url) {
            Storage::disk('public')->delete($post->image_url);
        }

        $post->delete();

        return ['message' => 'Post deletado com sucesso.'];
    }
}