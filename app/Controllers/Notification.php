<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class Notification extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Display notifications page
     */
    public function index()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 20;

        // Get notifications for current user
        $notifications = $this->notificationModel->getUserNotifications($userId, $perPage, ($page - 1) * $perPage);
        
        // Get unread count
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        $data = [
            'title' => 'Notifications',
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $this->notificationModel->getUserNotificationCount($userId),
            'badge_class' => function($type) {
                switch($type) {
                    case 'success': return 'success';
                    case 'warning': return 'warning';
                    case 'danger': return 'danger';
                    case 'info': return 'info';
                    default: return 'secondary';
                }
            }
        ];

        return view('notifications/index', $data);
    }

    /**
     * Mark notification as read
     */
    public function markRead($notificationId = null)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if ($notificationId) {
            $userId = get_user_id();
            $this->notificationModel->markAsRead($notificationId, $userId);
        }

        // Redirect back or to notifications page
        return redirect()->to('/notifications');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $this->notificationModel->markAllAsRead($userId);

        return redirect()->to('/notifications');
    }

    /**
     * Get unread notification count (AJAX endpoint)
     */
    public function getUnreadCount()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON(['count' => 0]);
        }

        $userId = get_user_id();
        $count = $this->notificationModel->getUnreadCount($userId);

        return $this->response->setJSON(['count' => $count]);
    }

    /**
     * Create a new notification (utility method)
     */
    public static function create($userId, $title, $message, $type = 'info', $data = [])
    {
        $notificationModel = new \App\Models\NotificationModel();
        
        $notificationData = [
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => json_encode($data),
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $notificationModel->insert($notificationData);
    }
}
