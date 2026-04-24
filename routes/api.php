<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;

 Route::get('/user', function (Request $request) {
     return $request->user();
 })->middleware('auth:sanctum');

Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/search',               [UserController::class, 'search']);
    Route::get('/users/{username}',           [UserController::class, 'show']);
    Route::put('/users/me',                   [UserController::class, 'update']);
    Route::post('/users/me/avatar',           [UserController::class, 'updateAvatar']);
    Route::post('/users/{id}/follow',         [FollowController::class, 'follow']);
    Route::delete('/users/{id}/unfollow',     [FollowController::class, 'unfollow']);
    Route::get('/users/{id}/followers',       [FollowController::class, 'followers']);
    Route::get('/users/{id}/following',       [FollowController::class, 'following']);
    Route::get('/users/{id}/is-following',    [FollowController::class, 'isFollowing']);
    Route::post('/posts',                     [PostController::class, 'store']);
    Route::get('/posts/{id}',                 [PostController::class, 'show']);
    Route::put('/posts/{id}',                 [PostController::class, 'update']);
    Route::delete('/posts/{id}',              [PostController::class, 'destroy']);
    Route::get('/users/{id}/posts',           [PostController::class, 'userPosts']);
    Route::get('/feed',                       [FeedController::class, 'index']);
    Route::post('/posts/{id}/like',           [LikeController::class, 'like']);
    Route::delete('/posts/{id}/unlike',       [LikeController::class, 'unlike']);
    Route::get('/posts/{id}/likes',           [LikeController::class, 'likes']);
    Route::post('/posts/{id}/comments',       [CommentController::class, 'store']);
    Route::get('/posts/{id}/comments',        [CommentController::class, 'index']);
    Route::put('/comments/{id}',              [CommentController::class, 'update']);
    Route::delete('/comments/{id}',           [CommentController::class, 'destroy']);
    Route::get('/notifications',              [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/read',         [NotificationController::class, 'markAsRead']);
});