<?php

namespace App\Controllers;

use App\Libraries\AppLogger;

class LogViewer extends BaseController
{
    /**
     * Display recent logs
     */
    public function index()
    {
        // Check if user is logged in and is admin
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get number of lines to display
        $lines = $this->request->getGet('lines') ?? 100;
        $lines = min($lines, 1000); // Limit to 1000 lines max

        // Get recent logs
        $logs = AppLogger::getRecentLogs($lines);

        // Parse logs for better display
        $parsedLogs = [];
        foreach ($logs as $logLine) {
            $parsedLogs[] = $this->parseLogLine($logLine);
        }

        $data = [
            'title' => 'Application Logs',
            'logs' => $parsedLogs,
            'total_lines' => count($parsedLogs),
            'requested_lines' => $lines
        ];

        return view('admin/log_viewer', $data);
    }

    /**
     * Clear all logs
     */
    public function clear()
    {
        // Check if user is logged in and is admin
        if (!is_user_logged_in() || !has_role('admin')) {
            return redirect()->to('/login');
        }

        AppLogger::clearLog();
        session()->setFlashdata('success', 'Logs cleared successfully.');
        return redirect()->to('/logs');
    }

    /**
     * Parse a log line into components
     */
    private function parseLogLine($logLine)
    {
        // Pattern: [timestamp] LEVEL: message | Context: {...}
        $pattern = '/^\[([^\]]+)\]\s+(\w+):\s+(.+?)(?:\s+\|\s+Context:\s+(.+))?$/';
        
        if (preg_match($pattern, $logLine, $matches)) {
            $context = isset($matches[4]) ? json_decode($matches[4], true) : [];
            
            return [
                'timestamp' => $matches[1],
                'level' => strtoupper($matches[2]),
                'message' => $matches[3],
                'context' => $context,
                'raw' => $logLine
            ];
        }

        return [
            'timestamp' => 'unknown',
            'level' => 'INFO',
            'message' => $logLine,
            'context' => [],
            'raw' => $logLine
        ];
    }
}
