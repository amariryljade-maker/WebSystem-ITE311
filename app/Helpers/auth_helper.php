<?php

if (!function_exists('is_user_logged_in')) {
    /**
     * Check if user is logged in
     */
    function is_user_logged_in() {
        if (function_exists('session') && is_callable('session')) {
            $session = session();
            return $session->get('logged_in') === true && $session->get('user_id');
        } else {
            // Fallback to $_SESSION for testing
            return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && isset($_SESSION['user_id']);
        }
    }
}

if (!function_exists('get_user_id')) {
    /**
     * Get current user ID
     */
    function get_user_id() {
        if (function_exists('session') && is_callable('session')) {
            return session()->get('user_id');
        } else {
            return $_SESSION['user_id'] ?? null;
        }
    }
}

if (!function_exists('get_user_role')) {
    /**
     * Get current user role
     */
    function get_user_role() {
        if (function_exists('session') && is_callable('session')) {
            return session()->get('user_role');
        } else {
            return $_SESSION['user_role'] ?? null;
        }
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if user has specific role
     */
    function has_role($role) {
        return get_user_role() === $role;
    }
}

if (!function_exists('logout_user')) {
    /**
     * Logout user
     */
    function logout_user() {
        $session = session();
        $session->destroy();
    }
}

if (!function_exists('check_session_timeout')) {
    /**
     * Check session timeout
     */
    function check_session_timeout() {
        $session = session();
        $lastActivity = $session->get('last_activity');
        $timeout = 30 * 60; // 30 minutes
        
        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            logout_user();
            return false;
        }
        
        return true;
    }
}

if (!function_exists('set_session_timeout')) {
    /**
     * Set session timeout
     */
    function set_session_timeout($minutes = 30) {
        session()->set('last_activity', time());
        session()->set('timeout', $minutes * 60);
    }
}
