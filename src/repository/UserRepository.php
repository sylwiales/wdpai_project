<?php

require_once 'Repository.php';
//require_once __DIR__.'/../models/User.php';

# po podłączeniu bazy se trzeba zrobić tabele związaną z aplikacją
# zrobić rejestracje a potem logowanie, żeby za każdym raze nie tworzyć user repository to zrobić w kontrolerze

class UserRepository extends Repository
{

    public function getUsers(): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users;
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $users;
    }

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }


    // public function addUser(User $user)
    // {
    //     $stmt = $this->database->connect()->prepare('
    //         INSERT INTO users_details (name, surname, phone)
    //         VALUES (?, ?, ?)
    //     ');

    //     $stmt->execute([
    //         $user->getName(),
    //         $user->getSurname(),
    //         $user->getPhone()
    //     ]);

    //     $stmt = $this->database->connect()->prepare('
    //         INSERT INTO users (email, password, id_user_details)
    //         VALUES (?, ?, ?)
    //     ');

    //     $stmt->execute([
    //         $user->getEmail(),
    //         $user->getPassword(),
    //         $this->getUserDetailsId($user)
    //     ]);
    // }

    // public function getUserDetailsId(User $user): int
    // {
    //     $stmt = $this->database->connect()->prepare('
    //         SELECT * FROM public.users_details WHERE name = :name AND surname = :surname AND phone = :phone
    //     ');
    //     $stmt->bindParam(':name', $user->getName(), PDO::PARAM_STR);
    //     $stmt->bindParam(':surname', $user->getSurname(), PDO::PARAM_STR);
    //     $stmt->bindParam(':phone', $user->getPhone(), PDO::PARAM_STR);
    //     $stmt->execute();

    //     $data = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $data['id'];
    // }
}