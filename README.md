# Cricket Player Management System

> A production-ready cricket player management system with secure authentication, role-based access control, and comprehensive player profiling capabilities.

## 🎯 Features

### Authentication & Security
- ✅ Secure login with email/username
- ✅ Email verification system
- ✅ Password reset functionality
- ✅ Account lockout protection (5 failed attempts)
- ✅ CSRF token protection
- ✅ XSS prevention
- ✅ SQL injection protection
- ✅ Activity logging & audit trail

### Role-Based Access Control
- ✅ Admin role with full management capabilities
- ✅ Player role with profile management
- ✅ Middleware-protected routes
- ✅ Permission-based access

### Player Management
- ✅ 88-field comprehensive questionnaire
- ✅ Profile completion tracking
- ✅ Statistics management
- ✅ Document uploads
- ✅ Email verification status

### Admin Dashboard
- ✅ Player statistics and analytics
- ✅ Recent login tracking
- ✅ New player registrations
- ✅ User search and filtering
- ✅ Account management
- ✅ System analytics with charts

### Email System
- ✅ PHPMailer integration
- ✅ Email verification
- ✅ Password reset emails
- ✅ Welcome emails
- ✅ HTML email templates

## 🔧 Technology Stack

- **Backend**: PHP 8.0+ with PSR-4 autoloading
- **Database**: MySQL 8.0+ with InnoDB
- **Frontend**: Bootstrap 5 + Font Awesome 6
- **Email**: PHPMailer
- **Architecture**: MVC-inspired with models, services, middleware

## 📦 Installation

### Quick Start

```bash
# 1. Clone repository
git clone https://github.com/cricdesign45-sudo/adsf.git
cd adsf

# 2. Install dependencies
composer install

# 3. Setup database
mysql -u root -p cricket_db < database/schema.sql

# 4. Configure environment
cp config/database.php.example config/database.php
cp .env.example .env

# 5. Run seeder for admin user
php database/seeder.php

# 6. Start server
php -S localhost:8000 -t public/
```

### Full Installation Guide

See [INSTALLATION.md](INSTALLATION.md) for detailed setup instructions including:
- Database configuration
- Email service setup
- File permissions
- Production deployment
- Troubleshooting

## 🔐 Security Features

- PDO Prepared Statements (SQL Injection Prevention)
- CSRF Token Protection on all forms
- XSS Prevention with output escaping
- Password hashing with bcrypt (cost 12)
- Session regeneration after login
- Secure cookies (HTTPOnly, Secure, SameSite=Strict)
- Rate limiting & account lockout
- Activity logging & audit trail
- File upload validation
- Input validation & sanitization

## 📂 Project Structure

```
adsf/
├── config/              # Configuration files
├── app/
│   ├── Core/           # Database, Auth, Session, Logger
│   ├── Models/         # User, PlayerProfile, etc.
│   ├── Services/       # EmailService
│   ├── Middleware/     # Auth, Validation
│   └── Helpers/        # Utility functions
├── public/             # Public pages (HTML/PHP)
├── database/           # Schema and seeders
├── uploads/            # User uploads
├── logs/               # Application logs
├── README.md           # This file
├── INSTALLATION.md     # Installation guide
└── composer.json       # Dependencies
```

## 🔑 Default Credentials

| Field | Value |
|-------|-------|
| Username | admin |
| Email | admin@cricket.local |
| Password | Admin@123456 |

⚠️ **Change password immediately after first login!**

## 🚀 Usage

### Admin Features
- Dashboard: `/admin/dashboard.php`
- Player Management: `/admin/players.php`
- Create Player: `/admin/create-player.php`
- Reports: `/admin/reports.php`
- Settings: `/admin/settings.php`

### Player Features
- Dashboard: `/player/dashboard.php`
- Edit Profile: `/player/profile.php`
- Statistics: `/player/statistics.php`
- Change Password: `/player/change-password.php`

### Authentication
- Login: `/login.php`
- Logout: `/logout.php`
- Forgot Password: `/forgot-password.php`
- Email Verification: `/verify-email.php`

## 📊 Database Schema

### Key Tables
- **users** - User accounts with roles
- **player_profiles** - 88-field player questionnaire
- **email_verifications** - Email verification tokens
- **password_resets** - Password reset tokens
- **login_attempts** - Rate limiting & security
- **activity_logs** - Audit trail
- **file_uploads** - Document management

## 🔗 API Endpoints

All endpoints are secured with authentication middleware.

## 📝 Configuration

### Database (`config/database.php`)
```php
return [
    'host' => 'localhost',
    'port' => 3306,
    'database' => 'cricket_db',
    'username' => 'root',
    'password' => '',
];
```

### Email (`config/email.php`)
```php
return [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'your-email@gmail.com',
    'password' => 'app-password',
];
```

## 🛠️ Development

### Code Standards
- PSR-4 Autoloading
- Namespaced classes
- Documented methods
- Security-first approach

### Testing
```bash
# Run database seeder
php database/seeder.php

# Test email configuration
# Check logs/error-*.log for issues
```

## 📚 Documentation

- [Installation Guide](INSTALLATION.md)
- [Database Schema](database/schema.sql)
- Security Implementation
- API Documentation (Coming soon)

## 🐛 Bug Reports

Report bugs via GitHub Issues:
https://github.com/cricdesign45-sudo/adsf/issues

## 📄 License

Proprietary - All rights reserved

## 👨‍💻 Author

**Cricket Management System Team**
- Repository: https://github.com/cricdesign45-sudo/adsf
- Contact: admin@cricket.local

## 🎉 Version

**Current Version**: 1.0.0  
**Last Updated**: June 12, 2024  
**Status**: ✅ Production Ready

---

## Production Checklist

Before deploying to production:

- [ ] Change admin password
- [ ] Update BASE_URL to actual domain
- [ ] Configure HTTPS/SSL certificate
- [ ] Set up proper email provider (Gmail/Outlook)
- [ ] Enable database backups
- [ ] Set up log monitoring
- [ ] Update .env with production values
- [ ] Review security settings
- [ ] Test all authentication flows
- [ ] Configure file permissions (644 files, 755 dirs)
- [ ] Disable debug mode
- [ ] Set up error monitoring

---

## Quick Links

- **Login Page**: http://localhost:8000/login.php
- **Admin Dashboard**: http://localhost:8000/admin/dashboard.php
- **Player Dashboard**: http://localhost:8000/player/dashboard.php
- **Installation Guide**: [INSTALLATION.md](INSTALLATION.md)
- **GitHub Repository**: https://github.com/cricdesign45-sudo/adsf

---

**⭐ If this project helps you, please consider giving it a star on GitHub!**
