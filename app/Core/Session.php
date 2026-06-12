<?php
/**
 * Session Management Class
 * Handles secure session operations with flash messaging
 */

namespace App\Core;

class Session
{
    /**
     * Start session with secure configuration
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $config = require CONFIG_PATH . '/app.php';
            $sessionConfig = $config['session'] ?? [];

            session_set_cookie_params([
                'lifetime' => ($sessionConfig['cookie_lifetime'] ?? 1440) * 60,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'] ?? 'localhost',
                'secure' => $sessionConfig['secure'] ?? true,
                'httponly' => $sessionConfig['httponly'] ?? true,
                'samesite' => $sessionConfig['samesite'] ?? 'Strict',
            ]);

            session_start();
        }
    }

    /**
     * Set session value
     */
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     */
    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     */
    public static function remove($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Destroy entire session
     */
    public static function destroy()
    {
        self::start();
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Regenerate session ID for security
     */
    public static function regenerate()
    {
        self::start();
        session_regenerate_id(true);
    }

    /**
     * Set flash message
     */
    public static function flash($type, $message)
    {
        self::set('flash_' . $type, $message);
    }

    /**
     * Get flash message
     */
    public static function getFlash($type)
    {
        $message = self::get('flash_' . $type, null);
        if ($message) {
            self::remove('flash_' . $type);
        }
        return $message;
    }

    /**
     * Get all flash messages
     */
    public static function getAllFlash()
    {
        self::start();
        $flashes = [];
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'flash_') === 0) {
                $type = str_replace('flash_', '', $key);
                $flashes[$type] = $value;
                unset($_SESSION[$key]);
            }
        }
        return $flashes;
    }
}
