<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ipAddress = $request->getIPAddress();
        $endpoint = $request->getUri()->getPath();
        
        // Check rate limits based on endpoint
        if (!$this->checkRateLimit($ipAddress, $endpoint)) {
            $this->logSecurityEvent('rate_limit_exceeded', "IP: {$ipAddress}, Endpoint: {$endpoint}", $ipAddress);
            $this->blockRequest('Rate limit exceeded. Please try again later.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }

    /**
     * Check rate limit for IP and endpoint
     */
    private function checkRateLimit($ipAddress, $endpoint)
    {
        $rateLimits = [
            '/login' => ['requests' => 5, 'window' => 300],      // 5 requests per 5 minutes
            '/register' => ['requests' => 3, 'window' => 600],   // 3 requests per 10 minutes
            '/forgot-password' => ['requests' => 3, 'window' => 3600], // 3 requests per hour
            'default' => ['requests' => 100, 'window' => 60]     // 100 requests per minute
        ];
        
        $limit = $rateLimits[$endpoint] ?? $rateLimits['default'];
        
        $key = "rate_limit_{$ipAddress}_{$endpoint}";
        $attempts = session()->get($key) ?? [];
        $currentTime = time();
        
        // Remove old attempts outside time window
        $attempts = array_filter($attempts, function($timestamp) use ($currentTime, $limit) {
            return ($currentTime - $timestamp) < $limit['window'];
        });
        
        if (count($attempts) >= $limit['requests']) {
            return false;
        }
        
        // Add current attempt
        $attempts[] = $currentTime;
        session()->set($key, $attempts);
        
        return true;
    }

    /**
     * Block request due to rate limit
     */
    private function blockRequest($message)
    {
        $response = service('response');
        $response->setStatusCode(429); // Too Many Requests
        $response->setBody(json_encode([
            'error' => 'Rate Limit Exceeded',
            'message' => $message,
            'retry_after' => 60, // seconds
            'timestamp' => date('Y-m-d H:i:s')
        ]));
        $response->setHeader('Content-Type', 'application/json');
        $response->setHeader('Retry-After', '60');
        
        echo $response->getBody();
        exit;
    }

    /**
     * Log security event
     */
    private function logSecurityEvent($eventType, $details, $ipAddress)
    {
        try {
            $securityLogModel = new \App\Models\SecurityLogModel();
            $securityLogModel->insert([
                'event_type' => $eventType,
                'details' => $details,
                'ip_address' => $ipAddress,
                'user_agent' => service('request')->getUserAgent(),
                'severity' => 'high',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Log to file if database fails
            log_message('error', "Security event failed to log: {$e->getMessage()}");
        }
    }
}
