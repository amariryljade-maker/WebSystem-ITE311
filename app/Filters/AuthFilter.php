<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            // Store the intended URL for redirect after login
            session()->set('redirect_after_login', current_url());
            
            // Redirect to login page
            return redirect()->to('/login');
        }
        
        // Check session timeout
        if (check_session_timeout()) {
            return; // logout_user() already called in check_session_timeout()
        }
        
        // Verify session integrity
        $this->verifySessionIntegrity($request);
        
        // Update last activity
        $this->updateLastActivity();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Additional authentication checks after request processing
        return $response;
    }

    /**
     * Verify session integrity
     */
    private function verifySessionIntegrity($request)
    {
        $session = session();
        
        // Check if session data is consistent
        if (!$session->get('user_id') || !$session->get('user_email') || !$session->get('user_role')) {
            $this->logSecurityEvent('session_integrity_failed', 'Missing session data', $request->getIPAddress());
            $this->destroySession();
            redirect()->to('/login')->send();
            exit;
        }
        
        // Check IP address consistency (optional - can be disabled for mobile users)
        $storedIP = $session->get('ip_address');
        $currentIP = $request->getIPAddress();
        
        if ($storedIP && $storedIP !== $currentIP) {
            $this->logSecurityEvent('ip_address_changed', "From: {$storedIP}, To: {$currentIP}", $currentIP);
            // Optionally destroy session on IP change
            // $this->destroySession();
            // redirect()->to('/login')->send();
            // exit;
        }
        
        // Check user agent consistency
        $storedUserAgent = $session->get('user_agent');
        $currentUserAgent = $request->getUserAgent();
        
        if ($storedUserAgent && $storedUserAgent !== $currentUserAgent) {
            $this->logSecurityEvent('user_agent_changed', "From: {$storedUserAgent}, To: {$currentUserAgent}", $currentIP);
            // Optionally destroy session on user agent change
            // $this->destroySession();
            // redirect()->to('/login')->send();
            // exit;
        }
    }

    /**
     * Update last activity timestamp
     */
    private function updateLastActivity()
    {
        $session = session();
        $session->set('last_activity', time());
    }

    /**
     * Destroy session and redirect to login
     */
    private function destroySession()
    {
        $session = session();
        $session->destroy();
        
        // Clear session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
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
                'user_id' => session()->get('user_id'),
                'severity' => 'high',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Log to file if database fails
            log_message('error', "Security event failed to log: {$e->getMessage()}");
        }
    }
}
