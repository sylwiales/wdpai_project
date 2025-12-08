<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class AccountController extends AppController {

    public function account() {
        if(isset($_COOKIE['username']))
            $username = $_COOKIE['username'];
        else{
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            return;
        }

    $userRepository = UserRepository::getInstance();
    return $this->render("account");
    }

}