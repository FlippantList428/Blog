<?php
require 'database.php';
session_start();

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $polaczenie->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $wynik = $stmt->get_result();
    $user = $wynik->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Nieprawidłowa nazwa użytkownika lub hasło";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pl">

<!--
    Plik: login.html
    Typ: Strona logowania użytkownika.
    Krótko: prosty formularz logowania; walidacja po stronie klienta w `main.js`.
    Uwaga: nie przechowujemy haseł w JS — backend powinien obsługiwać bezpieczeństwo.
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Logowanie - Blog o Linuxie</title>
    <script src="main.js" defer></script>
</head>

<body>
    <!-- Nagłówek sekcji logowania -->
    <header>
        <h1><a href="index.html">Linux Blog</a></h1>
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav id="nav-menu">
            <a href="index.html" class="btn">Start</a>
            <a href="news.html" class="btn">Nowości</a>
            <a href="about-me.html" class="btn">O nas</a>
            <a href="login.html" class="btn">Logowanie</a>
        </nav>
    </header>

    <!-- Skrypt obsługujący menu mobilne na stronie logowania (moved to main.js) -->

    <!-- Główny kontener strony logowania -->
    <main class="auth-container">
        <!-- Pudełko z formularzem logowania -->
        <section class="auth-box">
            <h1>Zaloguj się</h1>
            <form action="#" method="POST" id="loginForm">
                <!-- Pole nazwy użytkownika z walidacją HTML5 -->
                <div class="form-group">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" required minlength="3" maxlength="20"
                        placeholder="Wpisz login">
                    <small class="form-hint">Minimum 3 znaki</small>
                </div>
                <!-- Pole hasła z walidacją HTML5 -->
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" required minlength="8"
                        placeholder="Wpisz hasło">
                    <small class="form-hint">Minimum 8 znaków</small>
                </div>
                <!-- Przycisk wysyłający formularz -->
                <button type="submit" class="btn-submit">Zaloguj się</button>
            </form>
            <!-- Link do strony rejestracji dla nowych użytkowników -->
            <p class="auth-switch">
                Nie masz jeszcze konta? <a href="register.html">Zarejestruj się</a>
            </p>
        </section>
    </main>

    <!-- Skrypt obsługujący walidację formularza (moved to main.js) -->

    <!-- Stopka strony -->
    <footer>
        <p>&copy; 2026 Blog o Linuxie</p>
    </footer>
</body>

</html>

