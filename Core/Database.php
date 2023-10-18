<?php

namespace Demo\Core;

use Exception;
use PDO;
use PDOException;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;

    public $conn;

    public function __construct() {
        $this->loadConfiguration();
        $this->connect();
    }

    private function loadConfiguration() {
        $config = require('../secret.php');

        if (!isset($config['host']) || empty($config['host'])) {
            throw new Exception('Required configuration "host" is missing or empty.');
        }
        if (!isset($config['db_name']) || empty($config['db_name'])) {
            throw new Exception('Required configuration "db_name" is missing or empty.');
        }
        if (!isset($config['username']) || empty($config['username'])) {
            throw new Exception('Required configuration "username" is missing or empty.');
        }
        if (!isset($config['password'])) {
            throw new Exception('Required configuration "password" is missing.');
        }

        $this->host = $config['host'];
        $this->db_name = $config['db_name'];
        $this->username = $config['username'];
        $this->password = $config['password'];
    }

    private function connect() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
