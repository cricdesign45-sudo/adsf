<?php
/**
 * Database Connection Manager
 * Manages PDO database connections with singleton pattern
 */

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $pdo = null;
    private $config = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->config = require CONFIG_PATH . '/database.php';
    }

    /**
     * Get PDO singleton instance
     */
    public static function connect()
    {
        if (self::$pdo === null) {
            $database = new self();
            self::$pdo = $database->createConnection();
        }
        return self::$pdo;
    }

    /**
     * Create database connection
     */
    private function createConnection()
    {
        try {
            $dsn = "mysql:host={$this->config['host']}:" .
                   "{$this->config['port']};dbname={$this->config['database']};" .
                   "charset={$this->config['charset']}";

            $pdo = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            return $pdo;
        } catch (PDOException $e) {
            Logger::error('Database Connection Error: ' . $e->getMessage());
            die('Database connection failed. Please contact administrator.');
        }
    }

    /**
     * Prepare a query
     */
    public static function prepare($query)
    {
        return self::connect()->prepare($query);
    }

    /**
     * Execute prepared statement with parameters
     */
    public static function execute($query, $params = [])
    {
        $stmt = self::prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Close database connection
     */
    public static function disconnect()
    {
        self::$pdo = null;
    }
}
