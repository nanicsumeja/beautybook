<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view(
            'client.notifications.index',
            compact('notifications')
        );
    }

    public function markAsRead(
        Request $request,
        string $notification
    ): RedirectResponse {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead(
        Request $request
    ): RedirectResponse {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with(
            'success',
            'All notifications have been marked as read.'
        );
    }
}