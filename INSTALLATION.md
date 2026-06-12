<?php
/**
 * Installation Guide
 * Step-by-step setup instructions
 */
?>
# Cricket Player Management System - Installation Guide

## Prerequisites

- PHP 8.0 or higher
- MySQL 8.0 or higher
- Composer
- Web server (Apache/Nginx)
- SMTP server access (Gmail, Outlook, or Custom)

## Installation Steps

### 1. Clone Repository

```bash
git clone https://github.com/cricdesign45-sudo/adsf.git
cd adsf
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Create Database

```bash
mysql -u root -p
CREATE DATABASE cricket_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 4. Import Database Schema

```bash
mysql -u root -p cricket_db < database/schema.sql
```

### 5. Configure Database Connection

```bash
cp config/database.php.example config/database.php
```

Edit `config/database.php` with your database credentials:

```php
return [
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'cricket_db',
    'username' => 'root',
    'password' => 'your_password',
    'charset' => 'utf8mb4'
];
```

### 6. Configure Email Service

```bash
cp config/email.php.example config/email.php
```

Edit `config/email.php` with your SMTP settings:

For **Gmail**:
```php
return [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'your-email@gmail.com',
    'password' => 'your-app-password', // Use App Password, not regular password
    'from' => [
        'address' => 'noreply@cricket.local',
        'name' => 'Cricket Management System'
    ]
];
```

For **Outlook**:
```php
return [
    'driver' => 'smtp',
    'host' => 'smtp-mail.outlook.com',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'your-email@outlook.com',
    'password' => 'your-password',
    'from' => [
        'address' => 'noreply@cricket.local',
        'name' => 'Cricket Management System'
    ]
];
```

### 7. Set File Permissions

```bash
chmod 755 uploads/
chmod 755 logs/
chmod 755 public/
```

### 8. Update Base URL

Edit `config/constants.php`:

```php
define('BASE_URL', 'http://yourdomain.com'); // Update for production
```

### 9. Create Admin Account

Insert admin user directly into database:

```sql
INSERT INTO users (username, email, password, role, status, email_verified, profile_completed, created_at, updated_at) 
VALUES ('admin', 'admin@cricket.local', '$2y$12$...hash...', 'admin', 'active', 1, 1, NOW(), NOW());
```

To generate password hash in PHP:
```php
echo password_hash('Admin@123456', PASSWORD_BCRYPT, ['cost' => 12]);
```

### 10. Start Web Server

**Using PHP Built-in Server**:
```bash
php -S localhost:8000 -t public/
```

**Using Apache**:
Configure virtual host to point to `public/` directory.

### 11. Access Application

- **Login**: http://localhost:8000/login.php
- **Admin Dashboard**: http://localhost:8000/admin/dashboard.php

---

## Default Credentials

| Field | Value |
|-------|-------|
| Username | admin |
| Email | admin@cricket.local |
| Password | Admin@123456 |

**⚠️ Change password immediately after first login!**

---

## Folder Structure

```
adsf/
├── config/              # Configuration files
├── app/
│   ├── Core/           # Core classes (Database, Auth, Session)
│   ├── Models/         # Database models
│   ├── Services/       # Services (Email, etc)
│   ├── Middleware/     # Middleware (Auth, Validation)
│   └── Autoloader.php  # PSR-4 Autoloader
├── public/             # Public files (PHP pages, CSS, JS)
├── database/           # Database schema and seeders
├── uploads/            # User uploads (profiles, documents)
├── logs/               # Application logs
├── vendor/             # Composer dependencies
├── composer.json       # Composer configuration
└── README.md          # Project documentation
```

---

## Key Features

✅ **Authentication**
- Login with email or username
- Secure password hashing (bcrypt)
- Account lockout after 5 failed attempts
- Session regeneration after login
- Remember me functionality

✅ **Email Verification**
- Automatic verification email on registration
- 24-hour token expiration
- Resend verification option
- Admin can manually verify accounts

✅ **Password Reset**
- Secure password reset flow
- 1-hour token expiration
- Email notification on password change
- One-time token usage

✅ **Role-Based Access Control**
- Admin role for management
- Player role for athletes
- Middleware-protected routes
- Role-based redirects

✅ **Security**
- CSRF token protection
- XSS prevention with output escaping
- SQL injection protection (PDO prepared statements)
- Secure cookies (HTTPOnly, Secure, SameSite)
- Activity logging and audit trail
- File upload validation

✅ **Admin Features**
- Player management (CRUD)
- Dashboard with statistics
- User search and filtering
- Account suspension/activation
- Password reset for players
- Activity logs

✅ **Player Features**
- Complete profile questionnaire (88 fields)
- Profile progress tracking
- Statistics management
- Document uploads
- Email verification status

---

## Troubleshooting

### Email Not Sending

1. Check SMTP credentials in `config/email.php`
2. Verify firewall/port access (port 587 or 465)
3. Check `logs/error-*.log` for PHPMailer errors
4. Enable "Less secure app access" for Gmail accounts

### Database Connection Error

1. Verify database is running
2. Check credentials in `config/database.php`
3. Ensure database `cricket_db` exists
4. Check file permissions

### File Upload Errors

1. Ensure `uploads/` directory exists and is writable
2. Check PHP file upload settings in `php.ini`
3. Verify file size limits

### Session Issues

1. Ensure `logs/` directory exists and is writable
2. Check PHP session configuration
3. Verify `session.save_path` in `php.ini`

---

## Security Checklist for Production

- [ ] Change default admin password
- [ ] Update `BASE_URL` to actual domain
- [ ] Set `SESSION_SECURE` to `true` (HTTPS only)
- [ ] Configure proper file permissions (644 for files, 755 for directories)
- [ ] Enable HTTPS/SSL certificate
- [ ] Set up regular database backups
- [ ] Monitor error and activity logs
- [ ] Configure email provider properly
- [ ] Update `.env` with production values
- [ ] Disable debug mode in production

---

## Support & Documentation

For more information and updates, visit the repository:
https://github.com/cricdesign45-sudo/adsf

---

**Version**: 1.0.0  
**Last Updated**: June 12, 2024  
**License**: Proprietary
