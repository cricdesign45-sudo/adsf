#!/usr/bin/env php
<?php
/**
 * Database Seeder Script
 * Seeds the database with sample admin user
 */

require_once __DIR__ . '/../app/bootstrap.php';

use App\Models\User;
use App\Core\Logger;

try {
    // Check if admin already exists
    $existingAdmin = User::findByUsername('admin');
    if ($existingAdmin) {
        echo "Admin user already exists!\n";
        exit(1);
    }

    // Create admin user
    $adminId = User::create([
        'username' => 'admin',
        'email' => 'admin@cricket.local',
        'password' => 'Admin@123456',
        'role' => 'admin',
        'status' => 'active',
        'email_verified' => 1,
        'profile_completed' => 1
    ]);

    echo "✓ Admin user created successfully!\n";
    echo "Username: admin\n";
    echo "Email: admin@cricket.local\n";
    echo "Password: Admin@123456\n";
    echo "\n⚠️  IMPORTANT: Change the password immediately after first login!\n";

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    Logger::error('Database seeder error: ' . $e->getMessage());
    exit(1);
}
