<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function send(int $userId, string $type, array $data): void
    {
        if ($userId === Auth::id()) {
            return;
        }

        Notification::create([
            'user_id' => $userId,
            'type'    => $type,
            'data'    => $data,
        ]);
    }

    public function getNotifications()
    {
        return Auth::user()->notifications()->latest()->paginate(20);
    }

    public function getUnreadCount(): array
    {
        $count = Auth::user()->notifications()->whereNull('read_at')->count();
        return ['unread_count' => $count];
    }

    public function markAsRead(): array
    {
        Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        return ['message' => 'Todas as notificações foram marcadas como lidas.'];
    }
}