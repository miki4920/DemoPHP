<?php

namespace Demo\Core;

use Demo\Application\Controllers\HomeController;
use Demo\Application\Controllers\MemberController;
use Demo\Application\Controllers\SchoolController;

class Main
{
    public function __construct() {
        $this->setupDatabase();
        $this->run();
    }

    private function setupDatabase() {
        (new SetupDatabase())->createTables();
    }

    public function run() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $uriComponents = parse_url($_SERVER['REQUEST_URI']);
        $path = $uriComponents['path'];
        $queryParams = [];
        if (isset($uriComponents['query'])) {
            parse_str($uriComponents['query'], $queryParams);
        }
        $routes = [
            "GET" => [
                '/' => ['controller' => HomeController::class, 'method' => 'index'],
                '/pages/add-school' => ['controller' => SchoolController::class, 'method' => 'showAddSchool'],
                '/pages/add-member' => ['controller' => MemberController::class, 'method' => 'showAddMember'],
                '/pages/list-members' => ['controller' => MemberController::class, 'method' => 'listMembers'],
                '/api/member' => ['controller' => MemberController::class, 'method' => 'getMembersBySchool'],
        ],
            "POST" => [
                '/api/school' => ['controller' => SchoolController::class, 'method' => 'postSchool'],
                '/api/member' => ['controller' => MemberController::class, 'method' => 'postMember'],

            ]

        ];

        if (isset($routes[$requestMethod][$path])){
            $controllerName = $routes[$requestMethod][$path]['controller'];
            $method = $routes[$requestMethod][$path]['method'];
            $controller = new $controllerName();
            if (!empty($queryParams)) {
                call_user_func([$controller, $method], $queryParams);
            } else {
                call_user_func([$controller, $method]);
            }
        }
        else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}
