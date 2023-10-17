<?php

namespace Demo\Application\Models;

use PDO;

class Member extends BaseModel
{
    protected $tableName = "members";

    public function __construct($db) {
        parent::__construct($db);
    }

    public function getMembersBySchoolId($schoolId) {
        $stmt = $this->conn->prepare(
            "SELECT members.* FROM members 
         JOIN members_schools ON members.id = members_schools.member_id 
         WHERE members_schools.school_id = :school_id"
        );
        $stmt->bindParam(':school_id', $schoolId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}