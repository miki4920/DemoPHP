<?php

namespace Demo\Core;

abstract class Controller
{
    protected function view($view, $script = "", $data = [])
    {
        extract($data);
        $file = VIEW_PATH . $view . '.php';
        $script = VIEW_PATH . "/scripts/" . $script . '.php';
        if (file_exists($file)) {
            require_once VIEW_PATH . 'templates/header-template.php';
            require_once $file;
            require_once VIEW_PATH . 'templates/dependencies.php';
            if (file_exists($script)) {
                require_once $script;
            }
            require_once VIEW_PATH . 'templates/footer-template.php';
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
