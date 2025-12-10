<?php

namespace App\Models;

use CodeIgniter\Model;

class SecurityLogModel extends Model
{
    protected $table = 'security_logs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'event_type',
        'details',
        'ip_address',
        'user_agent',
        'user_id',
        'severity',
        'created_at'
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
        'event_type' => 'required|max_length[100]',
        'details' => 'required|max_length[1000]',
        'ip_address' => 'required|valid_ip',
        'user_agent' => 'permit_empty|max_length[500]',
        'user_id' => 'permit_empty|integer',
        'severity' => 'required|in_list[low,medium,high,critical]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setSeverity'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Set severity based on event type
     */
    protected function setSeverity(array $data)
    {
        $eventType = $data['data']['event_type'] ?? '';
        
        $severityMap = [
            'login_success' => 'low',
            'logout' => 'low',
            'registration_success' => 'low',
            'login_failed' => 'medium',
            'validation_failed' => 'medium',
            'rate_limit_exceeded' => 'high',
            'csrf_attack' => 'high',
            'account_locked' => 'high',
            'login_blocked' => 'high',
            'suspicious_activity' => 'critical',
            'security_breach' => 'critical'
        ];
        
        $data['data']['severity'] = $severityMap[$eventType] ?? 'medium';
        
        return $data;
    }

    /**
     * Get security events by type
     */
    public function getEventsByType($eventType, $limit = 100)
    {
        return $this->where('event_type', $eventType)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get security events by severity
     */
    public function getEventsBySeverity($severity, $limit = 100)
    {
        return $this->where('severity', $severity)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get security events by IP address
     */
    public function getEventsByIP($ipAddress, $limit = 100)
    {
        return $this->where('ip_address', $ipAddress)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get recent security events
     */
    public function getRecentEvents($hours = 24, $limit = 100)
    {
        $cutoffTime = date('Y-m-d H:i:s', time() - ($hours * 60 * 60));
        
        return $this->where('created_at >', $cutoffTime)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Get security statistics
     */
    public function getSecurityStats($days = 7)
    {
        $cutoffDate = date('Y-m-d H:i:s', time() - ($days * 24 * 60 * 60));
        
        $stats = $this->select('event_type, COUNT(*) as count')
                     ->where('created_at >', $cutoffDate)
                     ->groupBy('event_type')
                     ->findAll();
        
        $severityStats = $this->select('severity, COUNT(*) as count')
                             ->where('created_at >', $cutoffDate)
                             ->groupBy('severity')
                             ->findAll();
        
        return [
            'by_event_type' => $stats,
            'by_severity' => $severityStats
        ];
    }

    /**
     * Get top attacking IPs
     */
    public function getTopAttackingIPs($days = 7, $limit = 10)
    {
        $cutoffDate = date('Y-m-d H:i:s', time() - ($days * 24 * 60 * 60));
        
        return $this->select('ip_address, COUNT(*) as attack_count')
                   ->where('created_at >', $cutoffDate)
                   ->whereIn('event_type', ['login_failed', 'csrf_attack', 'rate_limit_exceeded'])
                   ->groupBy('ip_address')
                   ->orderBy('attack_count', 'DESC')
                   ->limit($limit)
                   ->findAll();
    }

    /**
     * Clean old security logs
     */
    public function cleanOldLogs($days = 90)
    {
        $cutoffDate = date('Y-m-d H:i:s', time() - ($days * 24 * 60 * 60));
        
        return $this->where('created_at <', $cutoffDate)->delete();
    }

    /**
     * Check for suspicious patterns
     */
    public function detectSuspiciousPatterns($hours = 1)
    {
        $cutoffTime = date('Y-m-d H:i:s', time() - ($hours * 60 * 60));
        
        $patterns = [];
        
        // Multiple failed logins from same IP
        $failedLogins = $this->select('ip_address, COUNT(*) as count')
                            ->where('created_at >', $cutoffTime)
                            ->where('event_type', 'login_failed')
                            ->groupBy('ip_address')
                            ->having('count >', 10)
                            ->findAll();
        
        if (!empty($failedLogins)) {
            $patterns['multiple_failed_logins'] = $failedLogins;
        }
        
        // CSRF attacks
        $csrfAttacks = $this->where('created_at >', $cutoffTime)
                           ->where('event_type', 'csrf_attack')
                           ->findAll();
        
        if (!empty($csrfAttacks)) {
            $patterns['csrf_attacks'] = $csrfAttacks;
        }
        
        // Rate limit violations
        $rateLimitViolations = $this->where('created_at >', $cutoffTime)
                                   ->where('event_type', 'rate_limit_exceeded')
                                   ->findAll();
        
        if (!empty($rateLimitViolations)) {
            $patterns['rate_limit_violations'] = $rateLimitViolations;
        }
        
        return $patterns;
    }
}
