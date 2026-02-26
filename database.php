<?php

// Konfiguracja połączenia z bazą danych MySQL/MariaDB
// Używamy zdefiniowanych tutaj zmiennych dla ułatwienia późniejszych modyfikacji
$host = 'localhost'; // Adres serwera bazy danych
$user = 'root';      // Nazwa użytkownika bazy danych
$pass = '';          // Hasło użytkownika bazy danych (puste dla lokalnego środowiska włączanego np. XAMPP)
$db   = 'Blog';      // Nazwa bazy danych, z którą skrypt ma się połączyć

// Utworzenie nowej instancji obiektu klasy mysqli
// Parametry są przekazywane, by nawiązać z serwerem bazodanowym połączenie obiektowe
$polaczenie = new mysqli($host, $user, $pass, $db);

// Sprawdzenie, czy podczas łączenia wystąpił błąd
if ($polaczenie->connect_error) {
    // Jeśli tak, skrypt zostaje przerwany z komunikatem błędu połączenia
    die('Błąd połączenia: ' . $polaczenie->connect_error);
}

// Ustawienie zestawowania znaków UTF-8 (wersja utf8mb4 wspiera wszystkie znaki w tym emoji i odpowiednie polskie znaczki)
$polaczenie->set_charset('utf8mb4');