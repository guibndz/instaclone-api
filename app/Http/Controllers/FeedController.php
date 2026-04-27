<?php

namespace App\Http\Controllers;

use App\Services\FeedService;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class FeedController extends Controller
{
    protected FeedService $feedService;

    public function __construct()
    {
        $this->feedService = new FeedService();
    }

    #[OA\Get(
        path: '/feed',
        summary: 'Lista os posts dos usuários seguidos',
        security: [['bearerAuth' => []]],
        tags: ['Feed'],
        responses: [new OA\Response(response: 200, description: 'Lista do feed')]
    )]
    public function index(): JsonResponse
    {
        $feed = $this->feedService->getFeed();
        return response()->json($feed);
    }
}