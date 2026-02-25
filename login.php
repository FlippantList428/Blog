<?php
require 'database.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    Plik: login.php
    Strona logowania użytkownika.
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

    <main class="auth-container">
        <section class="auth-box">
            <h1>Zaloguj się</h1>

            <?php if ($message): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="login.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika</label>
                    <input type="text" id="username" name="username" required minlength="3" maxlength="20"
                        placeholder="Wpisz login">
                    <small class="form-hint">Minimum 3 znaki</small>
                </div>

                <div class="form-group">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" name="password" required minlength="8"
                        placeholder="Wpisz hasło">
                    <small class="form-hint">Minimum 8 znaków</small>
                </div>

                <button type="submit" class="btn-submit">Zaloguj się</button>
            </form>

            <p class="auth-switch">
                Nie masz jeszcze konta? <a href="register.php">Zarejestruj się</a>
            </p>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Blog o Linuxie</p>
    </footer>
</body>

</html>