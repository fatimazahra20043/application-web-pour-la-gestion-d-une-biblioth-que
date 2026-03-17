<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsible for managing
 * user notifications
 */
class NotificationController extends Controller
{
    /**
     * Display a paginated list of notifications
     * for the authenticated user
     */
    public function index()
    {
        // Retrieve notifications for the logged-in user
        // Ordered by newest first and paginated
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($id)
    {
        // Find the notification belonging to the user
        $notification = Auth::user()->notifications()->findOrFail($id);

        // Mark it as read
        $notification->markAsRead();

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Mark all unread notifications as read
     */
    public function markAllAsRead()
    {
        // Update all unread notifications for the user
        Auth::user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
