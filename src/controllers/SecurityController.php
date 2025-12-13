<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = UserRepository::getInstance();
        if(isset($_COOKIE['username'])){
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/dashboard");
        }
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        // if ($_POST['csrf'] !== $_SESSION['csrf']) die("CSRF detected"); 

        $email = trim($_POST["email"] ?? '');
        $password = $_POST["password"] ?? '';

        if (empty($email) || empty($password)) {
            return $this->render('login', ['messages' => 'Fill all fields']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            return $this->render('login', ['messages' => 'Invalid email format']); 
        } 

        $userRow = $this->userRepository->getUserByEmail($email);

        if (!$userRow) {
            return $this->render('login', ['messages' => 'Wrong password or email']);
        }

        if (!password_verify($password, $userRow['hashedpassword'])) {
            return $this->render('login', ['messages' => 'Wrong password or email']);
        }

        ini_set('session.use_strict_mode', 1);
        ini_set('session.use_only_cookies', 1);

        session_set_cookie_params([
            'lifetime' => 10,
            'path' => '/',
            'domain' => 'localhost',
            'secure' => 'true',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        $cookie_name = "username";
        $cookie_value = $userRow['username'];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            return $this->render('login', ['messages' => 'Invalid email format']); 
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

    public function logout(){
        if(!$this->isPost()){
            return $this->render('account');
        }
        setcookie("username", "", time() - 3600, "/");
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        
        session_unset(); 
        session_destroy();
    }
}
