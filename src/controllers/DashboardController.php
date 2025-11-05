<?php

require_once 'AppController.php';

class DashboardController extends AppController {

    public function dashboard() {
        // tutaj logika logowania(sprawdzanie uzytkownika, zabezpieczenie inputu itd.)

        $cards = [
        [
            'id' => 1,
            'title' => 'Ace of Spades',
            'subtitle' => 'Legendary card',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/AS.png',
            'href' => '/cards/ace-of-spades'
        ],
        [
            'id' => 2,
            'title' => 'Queen of Hearts',
            'subtitle' => 'Classic romance',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/QH.png',
            'href' => '/cards/queen-of-hearts'
        ],
        [
            'id' => 3,
            'title' => 'King of Clubs',
            'subtitle' => 'Royal strength',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/KC.png',
            'href' => '/cards/king-of-clubs'
        ],
        [
            'id' => 4,
            'title' => 'Jack of Diamonds',
            'subtitle' => 'Sly and sharp',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/JD.png',
            'href' => '/cards/jack-of-diamonds'
        ],
        [
            'id' => 5,
            'title' => 'Ten of Hearts',
            'subtitle' => 'Lucky draw',
            'imageUrlPath' => 'https://deckofcardsapi.com/static/img/0H.png',
            'href' => '/cards/ten-of-hearts'
        ],
    ];

    return $this->render("dashboard", ['cards' => $cards]);
    }

}