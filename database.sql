--
-- Plik: database.sql
-- Typ: Skrypt inicjalizacyjny SQL (tworzenie bazy i tabel)
-- Krótko: definiuje bazę `users_data` oraz tabelę `users` z podstawowymi kolumnami.
-- Uwaga: plik jest tylko przykładowy — w środowisku produkcyjnym zadbaj o bezpieczeństwo haseł.
--
-- Skrypt SQL do inicjalizacji bazy danych użytkowników
-- Zawiera definicję bazy danych oraz tabeli przechowującej dane kont
-- 1. Tworzenie bazy danych (jeśli nie istnieje) z obsługą polskich znaków (utf8mb4)
CREATE DATABASE IF NOT EXISTS Blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Przełączenie na nowo utworzoną bazę
USE Blog;
-- 2. Tworzenie tabeli 'users' przechowującej informacje o zarejestrowanych użytkownikach
CREATE TABLE users (
    -- Unikalny identyfikator użytkownika (klucz główny)
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    -- Nazwa użytkownika (unikalna)
    username VARCHAR(40) NOT NULL UNIQUE,
    -- Adres email (musi być unikalny)
    email VARCHAR(100) NOT NULL UNIQUE,
    -- Zaszyfrowane hasło
    password VARCHAR(255) NOT NULL,
    -- Rola w systemie (domyślnie zwykły użytkownik)
    role ENUM('user', 'admin') DEFAULT 'user',
    -- Czy konto jest aktywne (0 lub 1)
    is_active TINYINT(1) DEFAULT 1,
    -- Data utworzenia konta
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- Data ostatniej modyfikacji
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;