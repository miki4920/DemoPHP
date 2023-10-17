<?php

namespace Demo\Application\Controllers;

use Demo\Application\Models\Member;
use Demo\Application\Models\School;
use Demo\Core\Controller;
use Demo\Core\Database;
use Exception;

class MemberController extends Controller
{
    protected $db;
    protected Member $model;
    protected School $schoolModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->model = new Member($this->db);
        $this->schoolModel = new School($this->db);
    }

    protected function validateData($data): string
    {
        if (empty($data['member_name'])) {
            return 'Member name is required.';
        }
        if (strlen($data['member_name']) > 100) {
            return 'Member name must be less than 100 characters.';
        }
        if (empty($data['member_email'])) {
            return 'Email is required.';
        }
        if (strlen($data['member_email']) > 100) {
            return 'Email must be less than 100 characters.';
        }
        if (!filter_var($data['member_email'], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format.';
        }
        $emailExists = $this->model->existsInTable('members', 'email', $data['member_email']);
        if ($emailExists) {
            return 'Email is already registered.';
        }
        if (empty($data['schools']) || !is_array($data['schools'])) {
            return 'Schools selection is required.';
        }
        foreach ($data['schools'] as $schoolId) {
            $schoolExists = $this->model->existsInTable('schools', 'id', $schoolId);
            if (!$schoolExists) {
                return 'One or more selected schools are invalid.';
            }
        }
        return "";
    }

    public function showAddMember() {
        $schoolData = $this->schoolModel->findAll();
        $this->view('add-member', ["schools" => $schoolData]);
    }

    public function listMembers()
    {
        $schoolData = $this->schoolModel->findAll();
        $this->view('list-members', ["schools" => $schoolData]);
    }

    public function getMembersBySchool($schoolId) {
        $membersList = $this->model->getMembersBySchoolId($schoolId);
        $this->sendJsonResponse(200, ['status' => 'success', 'data' => ['members' => $membersList]]);
    }

    public function postMember() {
        {
            $error = $this->validateData($_POST);
            if (!empty($error)) {
                $this->sendJsonResponse(400, ['status' => 'error', 'message' => $error]);
                return;
            }
            $memberData = [
                'name' => trim($_POST['member_name']),
                'email' => trim($_POST['member_email']),
            ];
            $schoolIDs = $_POST['schools'];
            $this->db->beginTransaction();
            try {
                $result = $this->model->create($memberData);
                if (!$result) {
                    $this->db->rollBack();
                    $this->sendJsonResponse(500, ['status' => 'error', 'message' => 'Error adding member.']);
                    return;
                }
                $memberID = $this->db->lastInsertId();
                foreach ($schoolIDs as $schoolID) {
                    $result = $this->model->createAssociation("members_schools", $memberID, $schoolID);
                    if (!$result) {
                        throw new Exception('Error creating a connection with school ID: ' . $schoolID);
                    }
                }
                $this->db->commit();
                $this->sendJsonResponse(201, ['status' => 'success', 'message' => 'Member added successfully!']);

            } catch (Exception $e) {
                $this->db->rollBack();
                $this->sendJsonResponse(500, ['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}