<?php

namespace App\Libraries;

class AppLogger
{
    private static $logFile = null;

    /**
     * Get the log file path
     */
    private static function getLogFile()
    {
        if (self::$logFile === null) {
            // Try to get WRITEPATH from CodeIgniter constants
            if (defined('WRITEPATH')) {
                self::$logFile = WRITEPATH . 'logs/app.log';
            } else {
                // Fallback for standalone usage
                self::$logFile = __DIR__ . '/../../writable/logs/app.log';
            }
        }
        return self::$logFile;
    }

    /**
     * Log a message with timestamp
     */
    public static function log($level, $message, $context = [])
    {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' | Context: ' . json_encode($context) : '';
        $logEntry = "[{$timestamp}] {$level}: {$message}{$contextStr}" . PHP_EOL;
        
        // Write to log file
        $logFile = self::getLogFile();
        $logDir = dirname($logFile);
        
        // Create directory if it doesn't exist
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        // Also write to CodeIgniter log if available
        if (function_exists('log_message')) {
            log_message($level, $message, $context);
        }
    }

    /**
     * Log info message
     */
    public static function info($message, $context = [])
    {
        self::log('info', $message, $context);
    }

    /**
     * Log error message
     */
    public static function error($message, $context = [])
    {
        self::log('error', $message, $context);
    }

    /**
     * Log debug message
     */
    public static function debug($message, $context = [])
    {
        self::log('debug', $message, $context);
    }

    /**
     * Log warning message
     */
    public static function warning($message, $context = [])
    {
        self::log('warning', $message, $context);
    }

    /**
     * Log login attempt
     */
    public static function loginAttempt($email, $success, $ip = null, $userAgent = null, $userId = null)
    {
        $data = [
            'email' => $email,
            'success' => $success,
            'ip' => $ip ?? ($_SERVER['REMOTE_ADDR'] ?? 'unknown'),
            'user_agent' => $userAgent ?? ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown'),
            'user_id' => $userId,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $status = $success ? 'SUCCESS' : 'FAILED';
        self::info("LOGIN {$status}: {$email}", $data);
    }

    /**
     * Log database query
     */
    public static function query($sql, $params = [], $executionTime = null)
    {
        $data = [
            'sql' => $sql,
            'params' => $params,
            'execution_time' => $executionTime
        ];
        
        self::debug("DATABASE QUERY", $data);
    }

    /**
     * Log exception
     */
    public static function exception(\Exception $e, $context = [])
    {
        $data = array_merge([
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], $context);

        self::error("EXCEPTION: " . $e->getMessage(), $data);
    }

    /**
     * Get recent log entries
     */
    public static function getRecentLogs($lines = 100)
    {
        $logFile = self::getLogFile();
        
        if (!file_exists($logFile)) {
            return [];
        }

        $logs = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_slice(array_reverse($logs), 0, $lines);
    }

    /**
     * Clear log file
     */
    public static function clearLog()
    {
        $logFile = self::getLogFile();
        
        if (file_exists($logFile)) {
            unlink($logFile);
        }
        self::info('Log file cleared');
    }
}
