<?php
// Włącz obsługę sesji
session_start();

// Wymagaj pliku z połączeniem do bazy danych
require 'database.php';

$message = '';

// Sprawdź, czy formularz został wysłany
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';

    // Podstawowa walidacja (dodatkowa względem tej w JS i HTML)
    if ($password !== $confirm_password) {
        $message = "Hasła nie są identyczne!";
    } else {
        // Sprawdź, czy użytkownik lub email już istnieje w bazie danych
        $stmt_check = $polaczenie->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $message = "Wybrana nazwa użytkownika lub emali jest już zajęta.";
        } else {
            // Hashowanie hasła dla bezpieczeństwa
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Wstaw nowego użytkownika do bazy za pomocą Prepared Statement
            $stmt = $polaczenie->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                // Po udanej rejestracji zaloguj użytkownika automatycznie lub przekieruj
                // Opcjonalnie: $_SESSION['user_id'] = $polaczenie->insert_id;
                header("Location: login.php?registered=1");
                exit;
            } else {
                $message = "Wystąpił błąd podczas rejestracji. Spróbuj ponownie później.";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<!--
    Plik: register.php
    Typ: Formularz rejestracyjny użytkownika i jego obsługa (przy użyciu PHP i bazy MySQL).
    Uwaga: Skrypt przyjmuje żądanie POST, waliduje dane i hashuje hasło do bazy danych.
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.png" type="image/png">
    <title>Rejestracja - Blog o Linuxie</title>
    <script src="main.js" defer></script>
</head>

<body>
    <!-- Nagłówek sekcji rejestracji -->
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
            <a href="login.php" class="btn">Logowanie</a>
        </nav>
    </header>

    <!-- Skrypt obsługujący menu mobilne (moved to main.js) -->

    <!-- Główny kontener strony rejestracji -->
    <main class="auth-container">
        <!-- Pudełko z formularzem rejestracji -->
        <section class="auth-box">
            <h1>Rejestracja</h1>

            <?php if (!empty($message)): ?>
                <p class="error-msg" style="color: red; margin-bottom: 10px; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form action="register.php" method="POST" id="registerForm">
                <!-- Pole nazwy użytkownika z wzorcem (pattern) i walidacją długości -->
                <div class="form-group">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" required minlength="3" maxlength="20"
                        pattern="[a-zA-Z0-9_]+" placeholder="Wpisz login">
                    <small class="form-hint">3-20 znaków (litery, cyfry, podkreślnik)</small>
                </div>
                <!-- Pole email -->
                <div class="form-group">
                    <label for="email">Adres email</label>
                    <input type="email" id="email" name="email" required placeholder="Wpisz email">
                    <small class="form-hint">Poprawny format email</small>
                </div>
                <!-- Pole hasła z wymogami bezpieczeństwa -->
                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" required minlength="8"
                        placeholder="Wpisz hasło">
                    <small class="form-hint">Min. 8 znaków, wielka litera, cyfra</small>
                </div>
                <!-- Pole potwierdzenia hasła -->
                <div class="form-group">
                    <label for="confirm-password">Potwierdź hasło</label>
                    <input type="password" id="confirm-password" name="confirm-password" required minlength="8"
                        placeholder="Powtórz hasło">
                    <small class="form-hint">Hasła muszą być identyczne</small>
                </div>
                <!-- Przycisk rejestracji -->
                <button type="submit" class="btn-submit">Zarejestruj się</button>
            </form>
            <!-- Link powrotny do logowania -->
            <p class="auth-switch">
                Masz już konto? <a href="login.php">Zaloguj się</a>
            </p>
        </section>
    </main>

    <!-- Skrypt obsługujący zaawansowaną walidację (moved to main.js) -->

    <!-- Stopka -->
    <footer>
        <p>&copy; 2026 Blog o Linuxie</p>
    </footer>
</body>

</html>

