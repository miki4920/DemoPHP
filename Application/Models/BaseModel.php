<?php

namespace Demo\Application\Models;

use PDO;

abstract class BaseModel {
    protected $conn;
    protected $tableName;
    protected $columns = [];

    public function __construct($db) {
        $this->conn = $db;
    }

    public function find($id) {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $query = "SELECT * FROM " . $this->tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data) {
        $keys = array_keys($data);
        $columnSql = implode(',', $keys);
        $bindingSql = ':' . implode(',:', $keys);

        $query = "INSERT INTO " . $this->tableName . " ({$columnSql}) VALUES ({$bindingSql})";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    public function update($id, array $data) {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = :$key";
        }
        $updatesSql = implode(', ', $updates);

        $query = "UPDATE " . $this->tableName . " SET ${updatesSql} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->tableName . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        return $stmt->execute();
    }

    public function existsInTable($table, $column, $value) {
        $query = "SELECT EXISTS(SELECT 1 FROM " . $table . " WHERE " . $column . " = :value LIMIT 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function doAllExistInTable(string $table, array $ids): bool
    {
        if (empty($ids)) {
            return false;
        }
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT COUNT(DISTINCT id) FROM {$table} WHERE id IN ({$placeholders})";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($ids);
        $count = $stmt->fetchColumn();
        return $count == count($ids);
    }

    public function createAssociation(string $associationTableName, $firstId, $secondId) {
        $query = "INSERT INTO " . $associationTableName . " VALUES (:firstId, :secondId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':firstId', $firstId);
        $stmt->bindParam(':secondId', $secondId);
        return $stmt->execute();
    }
}

?>