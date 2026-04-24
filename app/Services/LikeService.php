<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function like(int $postId): array
    {
        $user = Auth::user();
        $post = Post::findOrFail($postId);
        $post->likes()->firstOrCreate([
            'user_id' => $user->id
        ]);
        
        app(NotificationService::class)->send($post->user_id, 'like', [
            'post_id' => $post->id,
            'username' => $user->username
        ]);

        return ['message' => 'Post curtido com sucesso.'];
    }

    public function unlike(int $postId): array
    {
        $user = Auth::user();
        $post = Post::findOrFail($postId);

        $post->likes()->where('user_id', $user->id)->delete();

        return ['message' => 'Curtida removida.'];
    }

    public function getLikes(int $postId)
    {
        $post = Post::findOrFail($postId);
        
        return $post->likes()->with('user:id,name,username,avatar_url')->get();
    }
}