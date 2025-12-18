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
     * Get recent notifications for dropdown (AJAX endpoint)
     */
    public function getRecentNotifications()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON(['notifications' => [], 'count' => 0]);
        }

        $userId = get_user_id();
        $limit = $this->request->getGet('limit') ?? 5;
        $notifications = $this->notificationModel->getRecentNotifications($userId, $limit);
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        // Format notifications for JSON response
        $formattedNotifications = [];
        foreach ($notifications as $notification) {
            $formattedNotifications[] = [
                'id' => $notification['id'],
                'title' => esc($notification['title']),
                'message' => esc($notification['message']),
                'type' => $notification['type'],
                'created_at' => $notification['created_at'],
                'time_ago' => $this->timeAgo($notification['created_at']),
                'is_read' => (bool)$notification['is_read']
            ];
        }

        return $this->response->setJSON([
            'notifications' => $formattedNotifications,
            'count' => $unreadCount
        ]);
    }

    /**
     * Mark notification as read via AJAX
     */
    public function markReadAjax()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $notificationId = $this->request->getPost('notification_id');
        
        if (!$notificationId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notification ID required']);
        }

        $userId = get_user_id();
        $result = $this->notificationModel->markAsRead($notificationId, $userId);

        if ($result) {
            $unreadCount = $this->notificationModel->getUnreadCount($userId);
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Notification marked as read',
                'unread_count' => $unreadCount
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to mark as read']);
    }

    /**
     * Mark all notifications as read via AJAX
     */
    public function markAllReadAjax()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId = get_user_id();
        $result = $this->notificationModel->markAllAsRead($userId);

        if ($result) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'All notifications marked as read'
            ]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to mark all as read']);
    }

    /**
     * Helper function to convert timestamp to "time ago" format
     */
    private function timeAgo($datetime)
    {
        $time = strtotime($datetime);
        $now = time();
        $diff = $now - $time;

        if ($diff < 60) {
            return 'just now';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . ' minutes ago';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . ' hours ago';
        } elseif ($diff < 604800) {
            return floor($diff / 86400) . ' days ago';
        } else {
            return date('M j, Y', $time);
        }
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
