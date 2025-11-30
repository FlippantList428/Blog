-----------------------------------------
-- Utworzenie bazy danych użytkowników --
-----------------------------------------

CREATE DATABASE IF NOT EXISTS users_data
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE users_data;

-----------------------------------
-- Utworzenie tabeli użytkownicy --
-----------------------------------

CREATE TABLE users (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL,
    second_name VARCHAR(40),
    surname VARCHAR(40) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
