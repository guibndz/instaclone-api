<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function create(int $postId, Request $request): Comment
    {
        $data = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        return $post->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $data['body'],
        ]);
    }

    public function getPostComments(int $postId)
    {
        $post = Post::findOrFail($postId);
        
        return $post->comments()->with('user:id,name,username,avatar_url')->latest()->paginate(15);
    }

    public function update(int $id, Request $request): Comment
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Você só pode editar seus próprios comentários.');
        }

        $data = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->update($data);
        return $comment;
    }

    public function delete(int $id): array
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Você só pode deletar seus próprios comentários.');
        }

        $comment->delete();

        return ['message' => 'Comentário deletado com sucesso.'];
    }
}