<?php

// Plik odpowiedzialny za połączenie z bazą danych

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'Blog';

$polaczenie = new mysqli($host, $user, $pass, $db);

if ($polaczenie->connect_error) {
    die('Błąd połączenia: ' . $polaczenie->connect_error);
}

$polaczenie->set_charset('utf8mb4');