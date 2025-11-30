<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/CategoriesController.php';

class Routing {

    public static $routes = [
        'login' => [
            'controller' => "SecurityController",
            'action' => 'login'
        ],
        'register' => [
            'controller' => 'SecurityController',
            'action' => 'register'
        ],
        'dashboard' => [
            'controller' => "DashboardController",
            'action' => 'dashboard'
        ],
        'categories' => [
            'controller' => "CategoriesController",
            'action' => 'categories'
        ]
        ];

    public static function run(string $path) {
        switch ($path) {
            case 'dashboard':
                $controller_name = Routing::$routes[$path]["controller"];
                $controller = new $controller_name;
                
                $action = Routing::$routes[$path]["action"];
                $controller->$action();
                break;
                
            case 'login':
                $controller_name = Routing::$routes[$path]["controller"]; 
                $controller = new $controller_name; 

                $action = Routing::$routes[$path]["action"];
                $controller->$action(); 
                break;
            case 'register':
                $controller = Routing::$routes[$path]['controller'];
                $action = Routing::$routes[$path]['action'];

                $controllerObj = new $controller;
                $controllerObj->$action();
                break;
            case 'categories':
                $controller = Routing::$routes[$path]['controller'];
                $action = Routing::$routes[$path]['action'];

                $controllerObj = new $controller;
                $controllerObj->$action();
                break;
    default:
        include 'public/views/404.html';
        break;
} 
    }
}