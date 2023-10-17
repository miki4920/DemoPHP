<?php

namespace Demo\Core;

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
