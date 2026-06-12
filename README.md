# Cricket Player Management System

## Production-Ready Cricket Management Platform

A comprehensive, secure, and scalable cricket player management system built with PHP 8+, MySQL 8+, and Bootstrap 5.

### Features

- **Role-Based Access Control**: Admin and Player roles with strict permission enforcement
- **Authentication System**: Secure login with email verification and password reset
- **Player Management**: Complete player profile with 80+ questionnaire fields
- **Admin Dashboard**: Analytics, charts, and player statistics
- **Email System**: PHPMailer integration with multiple SMTP providers
- **Security**: PDO prepared statements, CSRF protection, XSS prevention, rate limiting
- **Reports**: PDF, Excel, and CSV export capabilities
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface

### System Requirements

- PHP 8.0 or higher
- MySQL 8.0 or higher
- Composer (for dependencies)
- SMTP Server access (Gmail, Outlook, or Custom)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/cricdesign45-sudo/adsf.git
   cd adsf
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure the database**
   - Copy `config/database.php.example` to `config/database.php`
   - Update database credentials

4. **Configure email settings**
   - Copy `config/email.php.example` to `config/email.php`
   - Update SMTP settings

5. **Import database schema**
   ```bash
   mysql -u root -p cricket_db < database/schema.sql
   ```

6. **Run seeder (optional)**
   ```bash
   php database/seeder.php
   ```

7. **Set file permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 logs/
   ```

### Default Admin Account

- **Username**: admin
- **Email**: admin@cricket.local
- **Password**: Admin@123456

### Directory Structure

```
adsf/
├── config/           # Configuration files
├── app/              # Application logic
├── public/           # Public assets
├── database/         # Database schema and seeders
├── uploads/          # User uploads
├── logs/             # Application logs
└── vendor/           # Composer dependencies
```

### Security Features

✓ PDO Prepared Statements
✓ CSRF Token Protection
✓ XSS Prevention
✓ SQL Injection Protection
✓ Password Hashing (bcrypt)
✓ Session Regeneration
✓ Rate Limiting
✓ Account Lockout
✓ Audit Logging
✓ File Upload Validation

### API Endpoints

All endpoints are secured with role-based middleware.

### Email Templates

- Welcome Email
- Email Verification
- Password Reset
- Password Changed
- Account Activated
- Account Suspended

### License

Propriety

### Support

For issues and feature requests, please open an issue in the repository.
