<?php

require_once 'Repository.php';
//require_once __DIR__.'/../models/User.php';

# po podłączeniu bazy se trzeba zrobić tabele związaną z aplikacją
# zrobić rejestracje a potem logowanie, żeby za każdym raze nie tworzyć user repository to zrobić w kontrolerze

class CardsRepository extends Repository
{
    public function getCardsByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM cards
            WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}