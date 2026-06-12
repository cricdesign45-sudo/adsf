-- Cricket Player Management System Database Schema
-- MySQL 8.0+

CREATE DATABASE IF NOT EXISTS cricket_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cricket_db;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'player') NOT NULL DEFAULT 'player',
    status ENUM('active', 'inactive', 'suspended', 'pending') NOT NULL DEFAULT 'pending',
    email_verified TINYINT(1) NOT NULL DEFAULT 0,
    profile_completed TINYINT(1) NOT NULL DEFAULT 0,
    last_login_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Player Profiles Table
CREATE TABLE IF NOT EXISTS player_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    full_name VARCHAR(100),
    date_of_birth DATE,
    age INT,
    gender ENUM('male', 'female', 'other'),
    mobile_number VARCHAR(20),
    alternate_number VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    country VARCHAR(50),
    postal_code VARCHAR(10),
    nationality VARCHAR(50),
    emergency_contact_name VARCHAR(100),
    emergency_contact_number VARCHAR(20),
    emergency_contact_relationship VARCHAR(50),
    primary_role ENUM('batsman', 'bowler', 'allrounder', 'wicketkeeper'),
    secondary_role ENUM('batsman', 'bowler', 'allrounder', 'wicketkeeper'),
    batting_style ENUM('right_handed', 'left_handed'),
    bowling_arm ENUM('right_arm', 'left_arm'),
    bowling_type VARCHAR(100),
    batting_position VARCHAR(100),
    is_wicket_keeper TINYINT(1) DEFAULT 0,
    captain_experience TINYINT(1) DEFAULT 0,
    vice_captain_experience TINYINT(1) DEFAULT 0,
    years_experience INT,
    current_team VARCHAR(100),
    previous_teams TEXT,
    cricket_academy VARCHAR(100),
    coach_name VARCHAR(100),
    highest_level_played VARCHAR(50),
    preferred_match_format VARCHAR(50),
    favorite_position VARCHAR(100),
    jersey_number INT,
    height VARCHAR(10),
    weight VARCHAR(10),
    fitness_level VARCHAR(50),
    dominant_hand ENUM('right', 'left'),
    blood_group VARCHAR(5),
    strongest_skill VARCHAR(100),
    secondary_skill VARCHAR(100),
    weakness_area VARCHAR(100),
    playing_style_description TEXT,
    favorite_cricketer VARCHAR(100),
    career_goal TEXT,
    matches_played INT DEFAULT 0,
    innings INT DEFAULT 0,
    runs INT DEFAULT 0,
    highest_score INT,
    batting_average DECIMAL(5,2),
    strike_rate DECIMAL(5,2),
    hundreds INT DEFAULT 0,
    fifties INT DEFAULT 0,
    fours INT DEFAULT 0,
    sixes INT DEFAULT 0,
    overs_bowled DECIMAL(5,1),
    wickets INT DEFAULT 0,
    best_bowling_figures VARCHAR(50),
    bowling_average DECIMAL(5,2),
    economy_rate DECIMAL(5,2),
    five_wicket_hauls INT DEFAULT 0,
    catches INT DEFAULT 0,
    run_outs INT DEFAULT 0,
    stumpings INT DEFAULT 0,
    fitness_score DECIMAL(5,2),
    sprint_time DECIMAL(5,2),
    yoyo_test_score INT,
    injury_history TEXT,
    current_injury_status VARCHAR(100),
    awards TEXT,
    tournament_wins TEXT,
    certificates TEXT,
    special_achievements TEXT,
    profile_photo VARCHAR(255),
    id_proof VARCHAR(255),
    availability_status ENUM('available', 'unavailable', 'injured'),
    preferred_training_days VARCHAR(255),
    preferred_practice_time VARCHAR(100),
    about_me TEXT,
    notes TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_primary_role (primary_role),
    INDEX idx_availability (availability_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Email Verification Table
CREATE TABLE IF NOT EXISTS email_verifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_token (token),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password Resets Table
CREATE TABLE IF NOT EXISTS password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_token (token),
    INDEX idx_expires_at (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Login Attempts Table (Rate Limiting)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_ip_address (ip_address),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Activity Logs Table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Remember Me Tokens Table
CREATE TABLE IF NOT EXISTS remember_me_tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- File Uploads Table
CREATE TABLE IF NOT EXISTS file_uploads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    upload_type ENUM('profile_photo', 'id_proof', 'certificate', 'video', 'other') NOT NULL,
    uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_upload_type (upload_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
