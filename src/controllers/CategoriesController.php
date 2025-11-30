<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class CategoriesController extends AppController {

    public function categories() {

        // tutaj logika logowania(sprawdzanie uzytkownika, zabezpieczenie inputu itd.)

    $userRepository = new UserRepository();
    //$users = $userRepository->getUsers();

    return $this->render("categories");
    }

}