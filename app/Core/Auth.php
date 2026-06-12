<?php
/**
 * Authentication Manager Class
 * Handles user authentication, role checks, and user sessions
 */

namespace App\Core;

class Auth
{
    private const USER_SESSION_KEY = 'auth_user';
    private const ROLE_SESSION_KEY = 'auth_role';

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated()
    {
        Session::start();
        return Session::has(self::USER_SESSION_KEY);
    }

    /**
     * Get authenticated user data
     */
    public static function user()
    {
        if (self::isAuthenticated()) {
            return Session::get(self::USER_SESSION_KEY);
        }
        return null;
    }

    /**
     * Get user ID
     */
    public static function id()
    {
        $user = self::user();
        return $user['id'] ?? null;
    }

    /**
     * Get user role
     */
    public static function role()
    {
        return Session::get(self::ROLE_SESSION_KEY, null);
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole($role)
    {
        return self::role() === $role;
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin()
    {
        return self::hasRole(ROLE_ADMIN);
    }

    /**
     * Check if user is player
     */
    public static function isPlayer()
    {
        return self::hasRole(ROLE_PLAYER);
    }

    /**
     * Set authenticated user in session
     */
    public static function setUser($user)
    {
        Session::start();
        Session::set(self::USER_SESSION_KEY, $user);
        Session::set(self::ROLE_SESSION_KEY, $user['role']);
        Session::regenerate();
    }

    /**
     * Logout user
     */
    public static function logout()
    {
        Logger::activity(self::id(), 'User logged out');
        Session::destroy();
    }

    /**
     * Get user username
     */
    public static function username()
    {
        $user = self::user();
        return $user['username'] ?? null;
    }

    /**
     * Get user email
     */
    public static function email()
    {
        $user = self::user();
        return $user['email'] ?? null;
    }
}
