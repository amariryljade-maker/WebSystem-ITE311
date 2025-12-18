<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for the current user via AJAX
     */
    public function get()
    {
        // Get current logged-in user ID
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        // Get unread count and notifications
        $unreadCount = $this->notificationModel->getUnreadCount($userId);
        $notifications = $this->notificationModel->getNotificationsForUser($userId);

        return $this->response->setJSON([
            'status' => 'success',
            'unread_count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read via POST
     */
    public function mark_as_read($id)
    {
        // Get current logged-in user ID
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }

        // Mark notification as read with user validation for security
        $result = $this->notificationModel->markAsReadWithUser($id, $userId);

        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Notification marked as read'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to mark notification as read'
            ]);
        }
    }
}
