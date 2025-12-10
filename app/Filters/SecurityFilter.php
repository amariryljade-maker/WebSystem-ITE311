<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SecurityFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Set security headers
        $this->setSecurityHeaders();
        
        // Check for suspicious requests
        $this->checkSuspiciousRequests($request);
        
        // Validate request method
        $this->validateRequestMethod($request);
        
        // Check for SQL injection patterns
        $this->checkSQLInjection($request);
        
        // Check for XSS patterns
        $this->checkXSS($request);
        
        // Validate file uploads
        $this->validateFileUploads($request);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Additional security measures after request processing
        $this->logSecurityEvents($request, $response);
        
        return $response;
    }

    /**
     * Set security headers
     */
    private function setSecurityHeaders()
    {
        $response = service('response');
        
        // Prevent XSS attacks
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        
        // Prevent MIME type sniffing
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        
        // Prevent clickjacking
        $response->setHeader('X-Frame-Options', 'DENY');
        
        // Strict Transport Security (HTTPS only)
        $response->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        
        // Content Security Policy
        $response->setHeader('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
            "img-src 'self' data: https:; " .
            "font-src 'self' https://cdn.jsdelivr.net; " .
            "connect-src 'self'; " .
            "frame-ancestors 'none';"
        );
        
        // Referrer Policy
        $response->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Permissions Policy
        $response->setHeader('Permissions-Policy', 
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), speaker=()'
        );
    }

    /**
     * Check for suspicious requests
     */
    private function checkSuspiciousRequests($request)
    {
        $userAgent = $request->getUserAgent();
        $ipAddress = $request->getIPAddress();
        
        // Check for bot user agents (less strict for development)
        $suspiciousUserAgents = [
            'sqlmap', 'nikto', 'nmap', 'masscan', 'zap', 'burp'
        ];
        
        foreach ($suspiciousUserAgents as $suspicious) {
            if (stripos($userAgent, $suspicious) !== false) {
                $this->logSecurityEvent('suspicious_user_agent', $userAgent, $ipAddress);
                // Don't block in development - just log
                // $this->blockRequest('Suspicious user agent detected');
            }
        }
        
        // Check for suspicious request patterns (less strict for development)
        $uri = $request->getUri();
        $suspiciousPatterns = [
            '/\.\./', '/\.\.\\', '/etc/passwd', '/proc/self/environ',
            '/wp-admin', '/phpmyadmin', '/\.env'
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (strpos($uri->getPath(), $pattern) !== false) {
                $this->logSecurityEvent('suspicious_request', $uri->getPath(), $ipAddress);
                // Don't block in development - just log
                // $this->blockRequest('Suspicious request pattern detected');
            }
        }
    }

    /**
     * Validate request method
     */
    private function validateRequestMethod($request)
    {
        $method = $request->getMethod();
        $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS', 'HEAD'];
        
        // Only log suspicious methods, don't block them in development
        if (!in_array($method, $allowedMethods)) {
            $this->logSecurityEvent('invalid_method', $method, $request->getIPAddress());
            // Don't block in development - just log
            // $this->blockRequest('Invalid HTTP method');
        }
    }

    /**
     * Check for SQL injection patterns
     */
    private function checkSQLInjection($request)
    {
        $input = $request->getPost() + $request->getGet();
        
        $sqlPatterns = [
            '/(\bunion\b.*\bselect\b)/i',
            '/(\bselect\b.*\bfrom\b)/i',
            '/(\binsert\b.*\binto\b)/i',
            '/(\bupdate\b.*\bset\b)/i',
            '/(\bdelete\b.*\bfrom\b)/i',
            '/(\bdrop\b.*\btable\b)/i',
            '/(\balter\b.*\btable\b)/i',
            '/(\bcreate\b.*\btable\b)/i',
            '/(\bexec\b|\bexecute\b)/i',
            '/(\bscript\b)/i',
            '/(\bjavascript\b)/i',
            '/(\bonload\b)/i',
            '/(\bonerror\b)/i'
        ];
        
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                foreach ($sqlPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        $this->logSecurityEvent('sql_injection_attempt', "Field: {$key}, Value: {$value}", $request->getIPAddress());
                        // Don't block in development - just log
                        // $this->blockRequest('SQL injection attempt detected');
                    }
                }
            }
        }
    }

    /**
     * Check for XSS patterns
     */
    private function checkXSS($request)
    {
        $input = $request->getPost() + $request->getGet();
        
        $xssPatterns = [
            '/<script[^>]*>.*?<\/script>/i',
            '/<iframe[^>]*>.*?<\/iframe>/i',
            '/<object[^>]*>.*?<\/object>/i',
            '/<embed[^>]*>.*?<\/embed>/i',
            '/<applet[^>]*>.*?<\/applet>/i',
            '/<meta[^>]*>/i',
            '/<link[^>]*>/i',
            '/<style[^>]*>.*?<\/style>/i',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            '/onmouseover\s*=/i'
        ];
        
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                foreach ($xssPatterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        $this->logSecurityEvent('xss_attempt', "Field: {$key}, Value: {$value}", $request->getIPAddress());
                        // Don't block in development - just log
                        // $this->blockRequest('XSS attempt detected');
                    }
                }
            }
        }
    }

    /**
     * Validate file uploads
     */
    private function validateFileUploads($request)
    {
        $files = $request->getFiles();
        
        if (!empty($files)) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            foreach ($files as $fieldName => $fileArray) {
                if (is_array($fileArray)) {
                    foreach ($fileArray as $file) {
                        if ($file->isValid()) {
                            // Check file size
                            if ($file->getSize() > $maxFileSize) {
                                $this->logSecurityEvent('file_upload_size_exceeded', "File: {$file->getName()}, Size: {$file->getSize()}", $request->getIPAddress());
                                // Don't block in development - just log
                                // $this->blockRequest('File size exceeds limit');
                            }
                            
                            // Check file extension
                            $extension = strtolower($file->getClientExtension());
                            if (!in_array($extension, $allowedExtensions)) {
                                $this->logSecurityEvent('file_upload_invalid_extension', "File: {$file->getName()}, Extension: {$extension}", $request->getIPAddress());
                                // Don't block in development - just log
                                // $this->blockRequest('Invalid file type');
                            }
                            
                            // Check MIME type
                            $mimeType = $file->getClientMimeType();
                            $allowedMimeTypes = [
                                'image/jpeg', 'image/png', 'image/gif',
                                'application/pdf', 'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'text/plain'
                            ];
                            
                            if (!in_array($mimeType, $allowedMimeTypes)) {
                                $this->logSecurityEvent('file_upload_invalid_mime', "File: {$file->getName()}, MIME: {$mimeType}", $request->getIPAddress());
                                // Don't block in development - just log
                                // $this->blockRequest('Invalid file MIME type');
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Log security events
     */
    private function logSecurityEvents($request, $response)
    {
        // Log high-risk requests
        if ($response->getStatusCode() >= 400) {
            $this->logSecurityEvent('http_error', "Status: {$response->getStatusCode()}, URI: {$request->getUri()}", $request->getIPAddress());
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
                'severity' => $this->getSeverity($eventType),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Log to file if database fails
            log_message('error', "Security event failed to log: {$e->getMessage()}");
        }
    }

    /**
     * Get severity level for event type
     */
    private function getSeverity($eventType)
    {
        $severityMap = [
            'suspicious_user_agent' => 'high',
            'suspicious_request' => 'high',
            'invalid_method' => 'medium',
            'sql_injection_attempt' => 'critical',
            'xss_attempt' => 'critical',
            'file_upload_size_exceeded' => 'medium',
            'file_upload_invalid_extension' => 'high',
            'file_upload_invalid_mime' => 'high',
            'http_error' => 'low'
        ];
        
        return $severityMap[$eventType] ?? 'medium';
    }

    /**
     * Block suspicious request
     */
    private function blockRequest($message)
    {
        $response = service('response');
        $response->setStatusCode(403);
        $response->setBody(json_encode([
            'error' => 'Access Denied',
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ]));
        $response->setHeader('Content-Type', 'application/json');
        
        echo $response->getBody();
        exit;
    }
}
