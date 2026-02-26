<?php
session_start();

// Usuń wszystkie zmienne sesyjne
$_SESSION = [];

// Zniszcz sesję
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Przekieruj z powrotem do logowania
header("Location: login.php");
exit;
?>
