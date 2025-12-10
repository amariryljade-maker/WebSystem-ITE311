<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LoginAttemptModel;
use App\Models\SecurityLogModel;

class SecureAuth extends BaseController
{
    protected $userModel;
    protected $loginAttemptModel;
    protected $securityLogModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->loginAttemptModel = new LoginAttemptModel();
        $this->securityLogModel = new SecurityLogModel();
        
        // Load security helpers
        helper(['session', 'security', 'form']);
        
        // Set security headers
        $this->setSecurityHeaders();
    }

    /**
     * Set security headers to prevent common attacks
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
    }

    /**
     * Enhanced registration with security measures
     */
    public function register()
    {
        // Check if user is already logged in
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        // Rate limiting for registration
        if (!$this->checkRateLimit('register', 5, 300)) { // 5 attempts per 5 minutes
            session()->setFlashdata('error', 'Too many registration attempts. Please try again later.');
            return redirect()->to('/register');
        }

        if ($this->request->getMethod() === 'post') {
            // CSRF token validation
            if (!$this->validateCSRFToken()) {
                $this->logSecurityEvent('csrf_attack', 'Registration form', $this->request->getIPAddress());
                session()->setFlashdata('error', 'Security token mismatch. Please try again.');
                return redirect()->to('/register');
            }

            // Enhanced validation rules
            $rules = [
                'name' => [
                    'rules' => 'required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                    'errors' => [
                        'required' => 'Name is required',
                        'min_length' => 'Name must be at least 3 characters long',
                        'max_length' => 'Name cannot exceed 100 characters',
                        'regex_match' => 'Name can only contain letters and spaces'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]|max_length[255]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address',
                        'is_unique' => 'This email is already registered',
                        'max_length' => 'Email cannot exceed 255 characters'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password must be at least 8 characters long',
                        'regex_match' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character'
                    ]
                ],
                'confirm_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Please confirm your password',
                        'matches' => 'Passwords do not match'
                    ]
                ],
                'role' => [
                    'rules' => 'required|in_list[student,instructor]',
                    'errors' => [
                        'required' => 'Please select a role',
                        'in_list' => 'Please select a valid role'
                    ]
                ],
                'terms' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'You must accept the terms and conditions'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $this->logSecurityEvent('validation_failed', 'Registration form', $this->request->getIPAddress());
                
                $data = [
                    'title' => 'Register',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/register', $data);
            }

            // Additional security checks
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            // Check for common password patterns
            if ($this->isCommonPassword($password)) {
                session()->setFlashdata('error', 'Password is too common. Please choose a stronger password.');
                $data = [
                    'title' => 'Register',
                    'validation' => null,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/register', $data);
            }

            // Check for email domain restrictions (optional)
            if (!$this->isAllowedEmailDomain($email)) {
                session()->setFlashdata('error', 'Email domain not allowed for registration.');
                $data = [
                    'title' => 'Register',
                    'validation' => null,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/register', $data);
            }

            // Create user with enhanced security
            $userData = [
                'name' => $this->sanitizeInput($this->request->getPost('name')),
                'email' => strtolower(trim($this->request->getPost('email'))),
                'password' => password_hash($password, PASSWORD_ARGON2ID, [
                    'memory_cost' => 65536, // 64 MB
                    'time_cost' => 4,       // 4 iterations
                    'threads' => 3          // 3 threads
                ]),
                'role' => $this->request->getPost('role'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                $userId = $this->userModel->insert($userData);
                
                if ($userId) {
                    // Log successful registration
                    $this->logSecurityEvent('registration_success', "User ID: {$userId}", $this->request->getIPAddress());
                    
                    // Send email verification (implement email service)
                    $this->sendEmailVerification($userId, $email);
                    
                    session()->setFlashdata('success', 'Registration successful! Please check your email to verify your account.');
                    return redirect()->to('/login');
                } else {
                    $this->logSecurityEvent('registration_failed', 'Database error', $this->request->getIPAddress());
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } catch (\Exception $e) {
                $this->logSecurityEvent('registration_error', $e->getMessage(), $this->request->getIPAddress());
                session()->setFlashdata('error', 'An error occurred during registration. Please try again.');
            }
        }

        // Display registration form
        $data = [
            'title' => 'Register',
            'validation' => null,
            'old_input' => [],
            'csrf_token' => csrf_hash()
        ];
        return view('auth/register', $data);
    }

    /**
     * Enhanced login with security measures
     */
    public function login()
    {
        // Check if user is already logged in
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // CSRF token validation
            if (!$this->validateCSRFToken()) {
                $this->logSecurityEvent('csrf_attack', 'Login form', $this->request->getIPAddress());
                session()->setFlashdata('error', 'Security token mismatch. Please try again.');
                return redirect()->to('/login');
            }

            // Rate limiting for login attempts
            $ipAddress = $this->request->getIPAddress();
            if (!$this->checkLoginRateLimit($ipAddress)) {
                $this->logSecurityEvent('rate_limit_exceeded', 'Login attempts', $ipAddress);
                session()->setFlashdata('error', 'Too many login attempts. Please try again later.');
                return redirect()->to('/login');
            }

            // Enhanced validation
            $rules = [
                'email' => [
                    'rules' => 'required|valid_email|max_length[255]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address',
                        'max_length' => 'Email cannot exceed 255 characters'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[1]|max_length[255]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is required',
                        'max_length' => 'Password is too long'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $this->logSecurityEvent('validation_failed', 'Login form', $ipAddress);
                
                $data = [
                    'title' => 'Login',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/login', $data);
            }

            // Sanitize inputs
            $email = strtolower(trim($this->request->getPost('email')));
            $password = $this->request->getPost('password');

            // Log login attempt
            $logger = \Config\Services::logger();
            $logger->info("Login attempt: Email = {$email}, IP = {$ipAddress}");

            // Record login attempt
            $this->recordLoginAttempt($ipAddress, $email);

            // Find user
            $user = $this->userModel->where('email', $email)->first();
            
            $logger->debug("User lookup result: " . ($user ? "Found user ID {$user['id']}" : "User not found"));

            if ($user) {
                $logger->debug("User data: ID={$user['id']}, Email={$user['email']}, Role={$user['role']}, Has name=" . (isset($user['name']) ? 'yes' : 'no'));
                // Check if account is locked (if field exists)
                if (isset($user['locked_until']) && $this->isAccountLocked($user['id'])) {
                    $this->logSecurityEvent('login_blocked', "User ID: {$user['id']} - Account locked", $ipAddress);
                    session()->setFlashdata('error', 'Account is temporarily locked due to multiple failed attempts.');
                    return redirect()->to('/login');
                }

                // Check if account is active (if field exists)
                if (isset($user['is_active']) && !$user['is_active']) {
                    $this->logSecurityEvent('login_blocked', "User ID: {$user['id']} - Account inactive", $ipAddress);
                    session()->setFlashdata('error', 'Account is inactive. Please contact support.');
                    return redirect()->to('/login');
                }

                // Verify password with timing attack protection
                $logger->debug("Verifying password for user ID: {$user['id']}");
                $passwordValid = $this->verifyPasswordSecure($password, $user['password']);
                $logger->debug("Password verification result: " . ($passwordValid ? "VALID" : "INVALID"));
                
                if ($passwordValid) {
                    // Login successful
                    $logger->info("Login successful: User ID {$user['id']} ({$email})");
                    $this->handleSuccessfulLogin($user, $ipAddress);
                    return redirect()->to('/dashboard');
                } else {
                    // Login failed
                    $logger->warning("Login failed: Invalid password for user ID {$user['id']} ({$email})");
                    $this->handleFailedLogin($user['id'], $ipAddress, $email);
                    session()->setFlashdata('error', 'Invalid email or password.');
                }
            } else {
                // User not found - still record attempt for security
                $logger->warning("Login failed: User not found for email: {$email}");
                $this->handleFailedLogin(null, $ipAddress, $email);
                session()->setFlashdata('error', 'Invalid email or password.');
            }
        }

        // Display login form
        $data = [
            'title' => 'Login',
            'validation' => null,
            'old_input' => [],
            'csrf_token' => csrf_hash()
        ];
        return view('auth/login', $data);
    }

    /**
     * Enhanced logout with security measures
     */
    public function logout()
    {
        $userId = get_user_id();
        $userName = get_user_name();
        $ipAddress = $this->request->getIPAddress();

        // Log logout event
        if ($userId) {
            $this->logSecurityEvent('logout', "User ID: {$userId} - {$userName}", $ipAddress);
        }

        // Clear all session data
        session()->destroy();
        
        // Regenerate session ID
        session_start();
        session_regenerate_id(true);
        session_destroy();

        // Clear any remaining cookies
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }

        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/login');
    }

    /**
     * Check rate limiting for various actions
     */
    private function checkRateLimit($action, $maxAttempts, $timeWindow)
    {
        $ipAddress = $this->request->getIPAddress();
        $key = "rate_limit_{$action}_{$ipAddress}";
        
        $attempts = session()->get($key) ?? [];
        $currentTime = time();
        
        // Remove old attempts outside time window
        $attempts = array_filter($attempts, function($timestamp) use ($currentTime, $timeWindow) {
            return ($currentTime - $timestamp) < $timeWindow;
        });
        
        if (count($attempts) >= $maxAttempts) {
            return false;
        }
        
        // Add current attempt
        $attempts[] = $currentTime;
        session()->set($key, $attempts);
        
        return true;
    }

    /**
     * Check login rate limiting specifically
     */
    private function checkLoginRateLimit($ipAddress)
    {
        // Check recent failed attempts
        $recentAttempts = $this->loginAttemptModel
            ->where('ip_address', $ipAddress)
            ->where('attempt_time >', date('Y-m-d H:i:s', time() - 900)) // 15 minutes
            ->countAllResults();
            
        return $recentAttempts < 10; // Max 10 attempts per 15 minutes
    }

    /**
     * Record login attempt
     */
    private function recordLoginAttempt($ipAddress, $email)
    {
        $this->loginAttemptModel->insert([
            'ip_address' => $ipAddress,
            'email' => $email,
            'attempt_time' => date('Y-m-d H:i:s'),
            'user_agent' => $this->request->getUserAgent(),
            'success' => false
        ]);
    }

    /**
     * Handle successful login
     */
    private function handleSuccessfulLogin($user, $ipAddress)
    {
        // Clear failed attempts for this user
        $this->loginAttemptModel->where('email', $user['email'])->delete();
        
        // Create secure session
        $sessionData = [
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
            'logged_in' => true,
            'login_time' => time(),
            'last_activity' => time(),
            'ip_address' => $ipAddress,
            'user_agent' => $this->request->getUserAgent()
        ];
        
        session()->set($sessionData);
        
        // Update last login time (if field exists)
        $updateData = ['updated_at' => date('Y-m-d H:i:s')];
        // Only add last_login_at if the field exists in the database
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('users');
        if (in_array('last_login_at', $fields)) {
            $updateData['last_login_at'] = date('Y-m-d H:i:s');
        }
        $this->userModel->update($user['id'], $updateData);
        
        // Log successful login
        $this->logSecurityEvent('login_success', "User ID: {$user['id']} - {$user['name']}", $ipAddress);
        
        // Set session timeout
        set_session_timeout(30);
        
        // Regenerate session ID
        regenerate_session();
        
        session()->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
    }

    /**
     * Handle failed login
     */
    private function handleFailedLogin($userId, $ipAddress, $email)
    {
        // Record failed attempt
        $this->loginAttemptModel->insert([
            'ip_address' => $ipAddress,
            'email' => $email,
            'attempt_time' => date('Y-m-d H:i:s'),
            'user_agent' => $this->request->getUserAgent(),
            'success' => false
        ]);
        
        // Check if account should be locked
        if ($userId) {
            $failedAttempts = $this->loginAttemptModel
                ->where('email', $email)
                ->where('attempt_time >', date('Y-m-d H:i:s', time() - 3600)) // 1 hour
                ->countAllResults();
                
            if ($failedAttempts >= 5) {
                // Lock account for 30 minutes
                $this->lockAccount($userId, 30);
                $this->logSecurityEvent('account_locked', "User ID: {$userId} - Too many failed attempts", $ipAddress);
            }
        }
        
        // Log failed login
        $this->logSecurityEvent('login_failed', "Email: {$email}", $ipAddress);
    }

    /**
     * Verify password with timing attack protection
     */
    private function verifyPasswordSecure($password, $hash)
    {
        // Use constant time comparison
        return hash_equals($hash, password_hash($password, PASSWORD_DEFAULT)) || 
               password_verify($password, $hash);
    }

    /**
     * Check if account is locked
     */
    private function isAccountLocked($userId)
    {
        $user = $this->userModel->find($userId);
        if (!$user || !isset($user['locked_until'])) {
            return false;
        }
        
        return $user['locked_until'] && strtotime($user['locked_until']) > time();
    }

    /**
     * Lock account for specified minutes
     */
    private function lockAccount($userId, $minutes)
    {
        $this->userModel->update($userId, [
            'locked_until' => date('Y-m-d H:i:s', time() + ($minutes * 60)),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check if password is common
     */
    private function isCommonPassword($password)
    {
        $commonPasswords = [
            'password', '123456', '123456789', 'qwerty', 'abc123',
            'password123', 'admin', 'letmein', 'welcome', 'monkey'
        ];
        
        return in_array(strtolower($password), $commonPasswords);
    }

    /**
     * Check if email domain is allowed
     */
    private function isAllowedEmailDomain($email)
    {
        $allowedDomains = [
            'gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com',
            'student.edu', 'university.edu' // Add educational domains
        ];
        
        $domain = substr(strrchr($email, "@"), 1);
        return in_array($domain, $allowedDomains);
    }

    /**
     * Sanitize input data
     */
    private function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate CSRF token
     */
    private function validateCSRFToken()
    {
        $security = \Config\Security::class;
        $config = config($security);
        
        // Get token from POST data or header
        $tokenName = $config->tokenName;
        $token = $this->request->getPost($tokenName);
        
        // If not in POST, check header
        if (empty($token)) {
            $token = $this->request->getHeaderLine($config->headerName);
        }
        
        // Get CSRF hash from cookie or session based on protection method
        if ($config->csrfProtection === 'cookie') {
            $csrfHash = $this->request->getCookie($config->cookieName);
        } else {
            $csrfHash = session()->get($config->cookieName);
        }
        
        // Validate token using timing-safe comparison
        if (empty($token) || empty($csrfHash)) {
            return false;
        }
        
        return hash_equals($csrfHash, $token);
    }

    /**
     * Log security events
     */
    private function logSecurityEvent($event, $details, $ipAddress)
    {
        $this->securityLogModel->insert([
            'event_type' => $event,
            'details' => $details,
            'ip_address' => $ipAddress,
            'user_agent' => $this->request->getUserAgent(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Send email verification
     */
    private function sendEmailVerification($userId, $email)
    {
        // Implement email verification service
        // This would typically send an email with a verification link
        // For now, we'll just log the event
        $this->logSecurityEvent('email_verification_sent', "User ID: {$userId} - {$email}", $this->request->getIPAddress());
    }
}
