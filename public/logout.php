<?php
/**
 * Logout Page
 * Securely log out the user
 */

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Auth;
use App\Core\Session;
use App\Middleware\AuthMiddleware;

// Require authentication
AuthMiddleware::authenticate();

// Log user activity
\App\Core\Logger::activity(Auth::id(), 'User logged out');

// Logout user
Auth::logout();

// Redirect to login
Session::flash('success', 'Logged out successfully!');
header('Location: ' . BASE_URL . '/login.php');
exit;
