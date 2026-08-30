<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InAppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get user notifications list and unread count.
     */
    public function getNotifications(Request $request)
    {
        $user = $request->user();

        $notifications = InAppNotification::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        $unreadCount = InAppNotification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ], 200);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();
        $notification = InAppNotification::where('user_id', $user->id)->where('id', $id)->first();

        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }

        $unreadCount = InAppNotification::where('user_id', $user->id)->where('is_read', false)->count();

        return response()->json([
            'status' => 'success',
            'unread_count' => $unreadCount,
        ], 200);
    }

    /**
     * Mark all user notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        InAppNotification::where('user_id', $user->id)->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'unread_count' => 0,
        ], 200);
    }
}
