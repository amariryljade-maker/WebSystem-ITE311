<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'ip_address',
        'email',
        'attempt_time',
        'user_agent',
        'success'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'ip_address' => 'required|valid_ip',
        'email' => 'required|valid_email',
        'attempt_time' => 'required|valid_date',
        'user_agent' => 'permit_empty|max_length[500]',
        'success' => 'required|in_list[0,1]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get failed login attempts for an IP address
     */
    public function getFailedAttemptsByIP($ipAddress, $timeWindow = 3600)
    {
        return $this->where('ip_address', $ipAddress)
                   ->where('success', 0)
                   ->where('attempt_time >', date('Y-m-d H:i:s', time() - $timeWindow))
                   ->orderBy('attempt_time', 'DESC')
                   ->findAll();
    }

    /**
     * Get failed login attempts for an email
     */
    public function getFailedAttemptsByEmail($email, $timeWindow = 3600)
    {
        return $this->where('email', $email)
                   ->where('success', 0)
                   ->where('attempt_time >', date('Y-m-d H:i:s', time() - $timeWindow))
                   ->orderBy('attempt_time', 'DESC')
                   ->findAll();
    }

    /**
     * Count failed attempts for IP in time window
     */
    public function countFailedAttemptsByIP($ipAddress, $timeWindow = 3600)
    {
        return $this->where('ip_address', $ipAddress)
                   ->where('success', 0)
                   ->where('attempt_time >', date('Y-m-d H:i:s', time() - $timeWindow))
                   ->countAllResults();
    }

    /**
     * Count failed attempts for email in time window
     */
    public function countFailedAttemptsByEmail($email, $timeWindow = 3600)
    {
        return $this->where('email', $email)
                   ->where('success', 0)
                   ->where('attempt_time >', date('Y-m-d H:i:s', time() - $timeWindow))
                   ->countAllResults();
    }

    /**
     * Clean old login attempts (older than specified days)
     */
    public function cleanOldAttempts($days = 30)
    {
        $cutoffDate = date('Y-m-d H:i:s', time() - ($days * 24 * 60 * 60));
        
        return $this->where('attempt_time <', $cutoffDate)->delete();
    }

    /**
     * Get suspicious login patterns
     */
    public function getSuspiciousPatterns($hours = 24)
    {
        $cutoffTime = date('Y-m-d H:i:s', time() - ($hours * 60 * 60));
        
        // Multiple IPs for same email
        $multipleIPs = $this->select('email, COUNT(DISTINCT ip_address) as ip_count')
                           ->where('attempt_time >', $cutoffTime)
                           ->where('success', 0)
                           ->groupBy('email')
                           ->having('ip_count >', 3)
                           ->findAll();
        
        // Multiple emails from same IP
        $multipleEmails = $this->select('ip_address, COUNT(DISTINCT email) as email_count')
                              ->where('attempt_time >', $cutoffTime)
                              ->where('success', 0)
                              ->groupBy('ip_address')
                              ->having('email_count >', 5)
                              ->findAll();
        
        return [
            'multiple_ips' => $multipleIPs,
            'multiple_emails' => $multipleEmails
        ];
    }
}
