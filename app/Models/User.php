<?php
/**
 * User Model
 * Handles user database operations
 */

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;

class User
{
    protected $table = 'users';

    /**
     * Create new user
     */
    public static function create($data)
    {
        $query = "INSERT INTO users (username, email, password, role, status, email_verified, profile_completed, created_at, updated_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $params = [
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
            $data['role'] ?? ROLE_PLAYER,
            $data['status'] ?? STATUS_PENDING,
            $data['email_verified'] ?? EMAIL_NOT_VERIFIED,
            $data['profile_completed'] ?? PROFILE_INCOMPLETE,
        ];

        try {
            Database::execute($query, $params);
            return Database::connect()->lastInsertId();
        } catch (\Exception $e) {
            Logger::error('User creation error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Find user by ID
     */
    public static function findById($id)
    {
        $query = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = Database::execute($query, [$id]);
        return $stmt->fetch();
    }

    /**
     * Find user by email
     */
    public static function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = Database::execute($query, [$email]);
        return $stmt->fetch();
    }

    /**
     * Find user by username
     */
    public static function findByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = ? LIMIT 1";
        $stmt = Database::execute($query, [$username]);
        return $stmt->fetch();
    }

    /**
     * Find by email or username
     */
    public static function findByEmailOrUsername($emailOrUsername)
    {
        $user = self::findByEmail($emailOrUsername);
        if (!$user) {
            $user = self::findByUsername($emailOrUsername);
        }
        return $user;
    }

    /**
     * Update user
     */
    public static function update($id, $data)
    {
        $allowed = ['username', 'email', 'password', 'status', 'email_verified', 'profile_completed', 'last_login_at'];
        $updates = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowed)) {
                if ($key === 'password') {
                    $updates[] = "$key = ?";
                    $params[] = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
                } else {
                    $updates[] = "$key = ?";
                    $params[] = $value;
                }
            }
        }

        if (empty($updates)) {
            return false;
        }

        $updates[] = 'updated_at = NOW()';
        $params[] = $id;

        $query = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";

        try {
            Database::execute($query, $params);
            return true;
        } catch (\Exception $e) {
            Logger::error('User update error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete user
     */
    public static function delete($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        try {
            Database::execute($query, [$id]);
            return true;
        } catch (\Exception $e) {
            Logger::error('User delete error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Verify password
     */
    public static function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Get all players with pagination
     */
    public static function getAllPlayers($limit = 15, $offset = 0, $filters = [])
    {
        $query = "SELECT * FROM users WHERE role = ?";
        $params = [ROLE_PLAYER];

        if (!empty($filters['status'])) {
            $query .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['email_verified'])) {
            $query .= " AND email_verified = ?";
            $params[] = $filters['email_verified'];
        }

        if (!empty($filters['search'])) {
            $query .= " AND (username LIKE ? OR email LIKE ?)";
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
        }

        $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $stmt = Database::execute($query, $params);
        return $stmt->fetchAll();
    }

    /**
     * Get players count
     */
    public static function getPlayersCount($filters = [])
    {
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
        $params = [ROLE_PLAYER];

        if (!empty($filters['status'])) {
            $query .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['email_verified'])) {
            $query .= " AND email_verified = ?";
            $params[] = $filters['email_verified'];
        }

        $stmt = Database::execute($query, $params);
        return $stmt->fetch()['count'] ?? 0;
    }

    /**
     * Get dashboard statistics
     */
    public static function getDashboardStats()
    {
        $stats = [];

        // Total players
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
        $stmt = Database::execute($query, [ROLE_PLAYER]);
        $stats['total_players'] = $stmt->fetch()['count'] ?? 0;

        // Active players
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ? AND status = ?";
        $stmt = Database::execute($query, [ROLE_PLAYER, STATUS_ACTIVE]);
        $stats['active_players'] = $stmt->fetch()['count'] ?? 0;

        // Inactive players
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ? AND status = ?";
        $stmt = Database::execute($query, [ROLE_PLAYER, STATUS_INACTIVE]);
        $stats['inactive_players'] = $stmt->fetch()['count'] ?? 0;

        // Verified players
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ? AND email_verified = ?";
        $stmt = Database::execute($query, [ROLE_PLAYER, EMAIL_VERIFIED]);
        $stats['verified_players'] = $stmt->fetch()['count'] ?? 0;

        // Pending verifications
        $query = "SELECT COUNT(*) as count FROM users WHERE role = ? AND email_verified = ?";
        $stmt = Database::execute($query, [ROLE_PLAYER, EMAIL_NOT_VERIFIED]);
        $stats['pending_verifications'] = $stmt->fetch()['count'] ?? 0;

        return $stats;
    }
}
