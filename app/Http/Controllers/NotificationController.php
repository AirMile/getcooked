<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display user's notifications (chronological, newest first).
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark single notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        // Redirect to action URL from notification data
        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete all notifications.
     */
    public function deleteAll(Request $request)
    {
        $request->user()
            ->notifications()
            ->delete();

        return back()->with('success', 'All notifications deleted.');
    }
}
