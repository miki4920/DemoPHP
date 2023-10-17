<?php

namespace Demo\Application\Models;

class School extends BaseModel
{
    protected $tableName = "schools";

    public function __construct($db) {
        parent::__construct($db);
    }
}