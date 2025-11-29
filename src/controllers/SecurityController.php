<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = trim($_POST["email"] ?? '');
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['messages' => 'Fill all fields']);
        }

        $userRow = $this->userRepository->getUserByEmail($email);

        if (!$userRow) {
            return $this->render('login', ['messages' => 'User not found']);
        }

        if (!password_verify($password, $userRow['password'])) {
            return $this->render('login', ['messages' => 'Wrong password']);
        }
        // TODO ciastrzeczka
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function register(){
        if(!$this->isPost()){
            return $this->render('register');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password1'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $username = $_POST['username'] ?? '';

        if(empty($email) || empty($password) || empty($password2)  || empty($username)){
            return $this->render('register', ['messages' => 'Fill all fields']);
        }
        if($password !== $password2){
            return $this->render('register', ['messages' => 'Passwords do not match']);
        }
        if($this->userRepository->getUserByEmail($email)){
            return $this->render('register', ['messages' => 'User with this email already exists']);
        }
        if($this->userRepository->getUserByUsername($username)){
            return $this->render('register', ['messages' => 'Username already taken']);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->createUser($email, $hashedPassword, $username);

        return $this->render('login', ['messages' => 'Account created successfully. Please log in.']);
    }
}
