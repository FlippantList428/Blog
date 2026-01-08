-- Skrypt SQL do inicjalizacji bazy danych użytkowników
-- Zawiera definicję bazy danych oraz tabeli przechowującej dane kont
-- 1. Tworzenie bazy danych (jeśli nie istnieje) z obsługą polskich znaków (utf8mb4)
CREATE DATABASE IF NOT EXISTS users_data CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Przełączenie na nowo utworzoną bazę
USE users_data;
-- 2. Tworzenie tabeli 'users' przechowującej informacje o zarejestrowanych użytkownikach
CREATE TABLE users (
    -- Unikalny identyfikator użytkownika (klucz główny)
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    -- Dane osobowe
    name VARCHAR(40) NOT NULL,
    -- Imię
    second_name VARCHAR(40),
    -- Drugie imię (opcjonalne)
    surname VARCHAR(40) NOT NULL,
    -- Nazwisko
    -- Dane logowania i kontaktowe
    email VARCHAR(100) NOT NULL UNIQUE,
    -- Adres email (musi być unikalny)
    password VARCHAR(255) NOT NULL,
    -- Zaszyfrowane hasło
    -- Uprawnienia i status konta
    role ENUM('user', 'admin') DEFAULT 'user',
    -- Rola w systemie (domyślnie zwykły użytkownik)
    is_active TINYINT(1) DEFAULT 1,
    -- Czy konto jest aktywne (0 lub 1)
    -- Znaczniki czasowe
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- Data utworzenia konta
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Data ostatniej modyfikacji
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;