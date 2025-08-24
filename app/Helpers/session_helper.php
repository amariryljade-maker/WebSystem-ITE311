<?php

/**
 * Session Helper Functions
 * Provides additional session management utilities
 */

if (!function_exists('is_user_logged_in')) {
    /**
     * Check if user is currently logged in
     * 
     * @return bool
     */
    function is_user_logged_in()
    {
        return session()->get('logged_in') === true;
    }
}

if (!function_exists('get_user_id')) {
    /**
     * Get current user ID from session
     * 
     * @return int|null
     */
    function get_user_id()
    {
        return session()->get('user_id');
    }
}

if (!function_exists('get_user_name')) {
    /**
     * Get current user name from session
     * 
     * @return string|null
     */
    function get_user_name()
    {
        return session()->get('user_name');
    }
}

if (!function_exists('get_user_email')) {
    /**
     * Get current user email from session
     * 
     * @return string|null
     */
    function get_user_email()
    {
        return session()->get('user_email');
    }
}

if (!function_exists('get_user_role')) {
    /**
     * Get current user role from session
     * 
     * @return string|null
     */
    function get_user_role()
    {
        return session()->get('user_role');
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if current user has specific role
     * 
     * @param string $role
     * @return bool
     */
    function has_role($role)
    {
        return session()->get('user_role') === $role;
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is admin
     * 
     * @return bool
     */
    function is_admin()
    {
        return has_role('admin');
    }
}

if (!function_exists('is_instructor')) {
    /**
     * Check if current user is instructor
     * 
     * @return bool
     */
    function is_instructor()
    {
        return has_role('instructor');
    }
}

if (!function_exists('is_student')) {
    /**
     * Check if current user is student
     * 
     * @return bool
     */
    function is_student()
    {
        return has_role('student');
    }
}

if (!function_exists('require_login')) {
    /**
     * Require user to be logged in, redirect to login if not
     * 
     * @param string $redirect_url
     * @return void
     */
    function require_login($redirect_url = '/login')
    {
        if (!is_user_logged_in()) {
            session()->setFlashdata('error', 'Please log in to access this page.');
            return redirect()->to($redirect_url);
        }
    }
}

if (!function_exists('require_role')) {
    /**
     * Require user to have specific role, redirect if not
     * 
     * @param string $role
     * @param string $redirect_url
     * @return void
     */
    function require_role($role, $redirect_url = '/dashboard')
    {
        if (!has_role($role)) {
            session()->setFlashdata('error', 'You do not have permission to access this page.');
            return redirect()->to($redirect_url);
        }
    }
}

if (!function_exists('logout_user')) {
    /**
     * Logout current user and destroy session
     * 
     * @param string $redirect_url
     * @return void
     */
    function logout_user($redirect_url = '/login')
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been successfully logged out.');
        return redirect()->to($redirect_url);
    }
}

if (!function_exists('regenerate_session')) {
    /**
     * Regenerate session ID for security
     * 
     * @return void
     */
    function regenerate_session()
    {
        session()->regenerate();
    }
}

if (!function_exists('set_session_timeout')) {
    /**
     * Set session timeout in minutes
     * 
     * @param int $minutes
     * @return void
     */
    function set_session_timeout($minutes = 30)
    {
        session()->set('session_timeout', time() + ($minutes * 60));
    }
}

if (!function_exists('check_session_timeout')) {
    /**
     * Check if session has timed out
     * 
     * @return bool
     */
    function check_session_timeout()
    {
        $timeout = session()->get('session_timeout');
        if ($timeout && time() > $timeout) {
            logout_user();
            return true;
        }
        return false;
    }
}
