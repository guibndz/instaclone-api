<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedService
{
public function getFeed()
    {
        $user = Auth::user();
        $followingIds = $user->following()->pluck('users.id');

        return Post::whereIn('user_id', $followingIds)
            ->with('user:id,name,username,avatar_url')
            ->withCount(['likes', 'comments']) 
            ->latest()
            ->cursorPaginate(10);
    }
}