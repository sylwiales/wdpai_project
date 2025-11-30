<?php

class User {
    private $email;
    private $password;
    private $username;

    public function __construct(
        string $email,
        string $password,
        string $username;
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}