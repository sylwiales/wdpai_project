<?php

require_once 'AppController.php';

class SecurityController extends AppController {


    public function login() {

        // TODO zwroc HTML logowania, przetworz dane
        return $this->render("login", ["message" => "Błędne hasło!"]);
    }

    public function register() {

        return $this->render("register");
    }
}