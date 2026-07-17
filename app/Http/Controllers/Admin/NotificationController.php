<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index(Request $request)
    {
        $notifications = SystemNotification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = SystemNotification::where('user_id', auth()->id())
                ->findOrFail($id);

            $notification->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while marking the notification as read.'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read for the logged-in user.
     */
    public function markAllAsRead(Request $request)
    {
        try {
            SystemNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while marking notifications as read.'
            ], 500);
        }
    }

    /**
     * Get the latest unread notifications for the dropdown.
     */
    public function getLatest(Request $request)
    {
        try {
            $notifications = SystemNotification::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'module' => $notification->module,
                        'is_read' => $notification->is_read,
                        'time_ago' => $notification->created_at->diffForHumans(),
                        'created_at' => $notification->created_at->format('M d, Y h:i A'),
                    ];
                });

            $unreadCount = SystemNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching notifications.'
            ], 500);
        }
    }
}
