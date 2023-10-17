<?php

namespace Demo\Core;

abstract class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        $file = VIEW_PATH . $view . '.php';
        if (file_exists($file)) {
            require_once VIEW_PATH . 'header-template.php';
            require_once $file;
            require_once VIEW_PATH . 'footer-template.php';
        } else {
            throw new \Exception("View $file not found");
        }
    }

    protected function sendJsonResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        echo json_encode($data);
    }

    protected function validateData($data) {

    }
}
