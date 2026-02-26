<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Pobierz nazwę użytkownika z sesji (lub wyświetl domyślną)
$username = $_SESSION['username'] ?? 'Użytkowniku';
?>
<!DOCTYPE html>
<html lang="pl">

<!--
    Plik: dashboard.php
    Widok panelu użytkownika po zalogowaniu.
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Panel Użytkownika - Linux Blog</title>
    <script src="main.js" defer></script>
</head>

<body>
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
            <a href="logout.php" class="btn">Wyloguj się</a>
        </nav>
    </header>

    <main class="auth-container">
        <section class="auth-box" style="max-width: 600px; text-align: center;">
            <h1>Witaj, <?= htmlspecialchars($username) ?>!</h1>
            <p>Udało Ci się pomyślnie zalogować do panelu.</p>
            <br>
            <p>Stąd możesz przejść do <a href="index.html">strony głównej</a> lub przeglądać najnowsze <a href="news.html">wpisy</a>.</p>
            <br><br>
            <a href="logout.php" class="btn-submit" style="display: inline-block; width: auto; padding: 10px 20px; text-decoration: none;">Wyloguj się</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Blog o Linuxie</p>
    </footer>
</body>
</html>
