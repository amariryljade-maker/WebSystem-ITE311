<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'message', 'is_read', 'created_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Get notifications for a specific user
     */
    public function getUserNotifications($userId, $limit = 20, $offset = 0)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    /**
     * Get latest notifications for a user (limit 5)
     */
    public function getNotificationsForUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll(5);
    }

    /**
     * Get total notification count for user
     */
    public function getUserNotificationCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->countAllResults();
    }

    /**
     * Get unread notification count for user
     */
    public function getUnreadCount($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        return $this->where('id', $notificationId)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Mark notification as read (with user validation)
     */
    public function markAsReadWithUser($notificationId, $userId)
    {
        return $this->where('id', $notificationId)
                    ->where('user_id', $userId)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Create a new notification
     */
    public function createNotification($userId, $message)
    {
        $notificationData = [
            'user_id' => $userId,
            'message' => $message,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($notificationData);
    }

    /**
     * Delete old notifications (cleanup)
     */
    public function deleteOldNotifications($daysOld = 30)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$daysOld} days"));
        
        return $this->where('created_at <', $cutoffDate)
                    ->delete();
    }

    /**
     * Get recent notifications for dashboard
     */
    public function getRecentNotifications($userId, $limit = 5)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }
}
