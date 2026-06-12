<?php
/**
 * CSRF Protection Class
 * Prevents Cross-Site Request Forgery attacks
 */

namespace App\Core;

class CSRF
{
    private const TOKEN_KEY = 'csrf_token';
    private const TOKEN_LENGTH = 32;

    /**
     * Generate CSRF token
     */
    public static function generateToken()
    {
        Session::start();

        if (!Session::has(self::TOKEN_KEY)) {
            Session::set(self::TOKEN_KEY, bin2hex(random_bytes(self::TOKEN_LENGTH)));
        }

        return Session::get(self::TOKEN_KEY);
    }

    /**
     * Get CSRF token
     */
    public static function getToken()
    {
        return self::generateToken();
    }

    /**
     * Verify CSRF token
     */
    public static function verify($token)
    {
        if (!hash_equals(self::getToken(), $token ?? '')) {
            throw new \Exception('Invalid CSRF token');
        }
        return true;
    }

    /**
     * Get CSRF token input field HTML
     */
    public static function tokenField()
    {
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(self::getToken(), ENT_QUOTES, 'UTF-8') . '" />';
    }

    /**
     * Validate POST request CSRF token
     */
    public static function validateRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            return self::verify($token);
        }
        return true;
    }
}
