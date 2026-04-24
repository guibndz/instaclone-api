<?php

namespace App\Http\Controllers;

use App\Services\FeedService;
use Illuminate\Http\JsonResponse;

class FeedController extends Controller
{
    protected FeedService $feedService;

    public function __construct()
    {
        $this->feedService = new FeedService();
    }

    public function index(): JsonResponse
    {
        $feed = $this->feedService->getFeed();
        return response()->json($feed);
    }
}