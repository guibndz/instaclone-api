<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function index(): JsonResponse
    {
        return response()->json($this->notificationService->getNotifications());
    }

    public function unreadCount(): JsonResponse
    {
        return response()->json($this->notificationService->getUnreadCount());
    }

    public function markAsRead(): JsonResponse
    {
        return response()->json($this->notificationService->markAsRead());
    }
}