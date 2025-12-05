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
        ],
        'account' => [
            'controller' => "AccountController",
            'action' => 'account'
        ],
        'search-cards' => [
            'controller' => "DashboardController",
            'action' => 'search'
        ]
        ];

    public static function run(string $path) {
        switch ($path) {
            case 'dashboard':      
            case 'login':
            case 'register':
            case 'search-cards':
            case 'categories':
            case 'account':
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