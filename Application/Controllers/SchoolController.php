<?php

namespace Demo\Application\Controllers;

use Demo\Application\Models\School;
use Demo\Core\Controller;
use Demo\Core\Database;

class SchoolController extends Controller
{
    protected $db;
    protected School $model;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->model = new School($this->db);
    }

    protected function validateData($data)
    {
        if (empty($data['school_name'])) {
            return 'School name is required.';
        }
        if (strlen($data['school_name']) > 100) {
            return 'School name must be less than 100 characters.';
        }
        if (!preg_match('/^[a-zA-Z0-9 ]+$/', $data['school_name'])) {
            return'School name can only contain alphanumeric characters and spaces.';
        }
        $exists = $this->model->existsInTable('schools', 'school_name', $data['school_name']);
        if ($exists) {
            return 'School name already exists.';
        }
        return "";
    }

    public function showAddSchool()
    {
        $this->view('add-school');
    }

    public function postSchool()
    {
        $error = $this->validateData($_POST);

        if (empty($error)) {
            $schoolData = ['school_name' => trim($_POST['school_name'])];
            $result = $this->model->create($schoolData);

            if ($result) {
                $this->sendJsonResponse(201, ['status' => 'success', 'message' => 'School added successfully!']);
            } else {
                $this->sendJsonResponse(500, ['status' => 'error', 'message' => 'Error adding school.']);
            }
        } else {
            $this->sendJsonResponse(400, ['status' => 'error', 'message' => $error]);
        }
    }

}