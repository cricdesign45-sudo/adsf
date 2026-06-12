<?php
/**
 * Application Constants
 */

// Roles
define('ROLE_ADMIN', 'admin');
define('ROLE_PLAYER', 'player');

// User Status
define('STATUS_ACTIVE', 'active');
define('STATUS_INACTIVE', 'inactive');
define('STATUS_SUSPENDED', 'suspended');
define('STATUS_PENDING', 'pending');

// Email Verification
define('EMAIL_VERIFIED', 1);
define('EMAIL_NOT_VERIFIED', 0);

// Profile Status
define('PROFILE_COMPLETED', 1);
define('PROFILE_INCOMPLETE', 0);

// Cricket Roles
define('CRICKET_BATSMAN', 'batsman');
define('CRICKET_BOWLER', 'bowler');
define('CRICKET_ALLROUNDER', 'allrounder');
define('CRICKET_WICKETKEEPER', 'wicketkeeper');

// Batting Styles
define('BATTING_RIGHT_HANDED', 'right_handed');
define('BATTING_LEFT_HANDED', 'left_handed');

// Bowling Arms
define('BOWLING_RIGHT_ARM', 'right_arm');
define('BOWLING_LEFT_ARM', 'left_arm');

// Match Formats
define('FORMAT_T10', 't10');
define('FORMAT_T20', 't20');
define('FORMAT_ODI', 'odi');
define('FORMAT_TEST', 'test');

// Paths
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOADS_PATH', BASE_PATH . '/uploads');
define('LOGS_PATH', BASE_PATH . '/logs');

// URLs
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8000');
