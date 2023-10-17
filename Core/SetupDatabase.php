<?php

namespace Demo\Core;

use Demo\Core\Database;

class SetupDatabase {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function createTables() {
        $sqls = [
            "CREATE TABLE IF NOT EXISTS members (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                UNIQUE (email)
            )",

            "CREATE TABLE IF NOT EXISTS schools (
                id INT AUTO_INCREMENT PRIMARY KEY,
                school_name VARCHAR(100) NOT NULL,
                UNIQUE (school_name)
            )",

            "CREATE TABLE IF NOT EXISTS members_schools (
                member_id INT NOT NULL,
                school_id INT NOT NULL,
                PRIMARY KEY (member_id, school_id),
                FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
                FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE RESTRICT
            )"
        ];

        foreach ($sqls as $sql) {
            $stmt = $this->conn->prepare($sql);

            if (!$stmt->execute()) {
                echo "Error executing query: " . implode(" ", $stmt->errorInfo());
            }
        }
    }
}
