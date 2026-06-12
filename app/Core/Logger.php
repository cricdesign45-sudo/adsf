<?php
/**
 * Logger - Activity and Error Logging System
 * Handles application logging and activity tracking
 */

namespace App\Core;

class Logger
{
    private $logPath = '';

    public function __construct()
    {
        $this->logPath = LOGS_PATH . '/';
        $this->ensureLogsDirectory();
    }

    /**
     * Ensure logs directory exists
     */
    private function ensureLogsDirectory()
    {
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0755, true);
        }
    }

    /**
     * Log activity to database
     */
    public static function activity($userId, $action, $ipAddress = null)
    {
        if ($ipAddress === null) {
            $ipAddress = self::getIpAddress();
        }

        $query = "INSERT INTO activity_logs (user_id, action, ip_address, created_at) 
                  VALUES (?, ?, ?, NOW())";
        
        try {
            Database::execute($query, [$userId, $action, $ipAddress]);
        } catch (\Exception $e) {
            self::error('Activity log error: ' . $e->getMessage());
        }
    }

    /**
     * Log error to file
     */
    public static function error($message, $context = [])
    {
        $logger = new self();
        $file = $logger->logPath . 'error-' . date('Y-m-d') . '.log';
        
        $logEntry = '[' . date('Y-m-d H:i:s') . '] ' . $message;
        if (!empty($context)) {
            $logEntry .= ' | Context: ' . json_encode($context);
        }
        $logEntry .= PHP_EOL;

        file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log info to file
     */
    public static function info($message, $context = [])
    {
        $logger = new self();
        $file = $logger->logPath . 'info-' . date('Y-m-d') . '.log';
        
        $logEntry = '[' . date('Y-m-d H:i:s') . '] ' . $message;
        if (!empty($context)) {
            $logEntry .= ' | Context: ' . json_encode($context);
        }
        $logEntry .= PHP_EOL;

        file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Get client IP address
     */
    public static function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : 'UNKNOWN';
    }
}
