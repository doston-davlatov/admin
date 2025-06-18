/*
 * ======================================================
 *                    DATABASE YARATISH              
 * ======================================================
 */

-- Avvalgi bazani o‘chiramiz (agar mavjud bo‘lsa)
DROP DATABASE IF EXISTS doston_website_db;

-- Yangi bazani yaratamiz
CREATE DATABASE doston_website_db;

-- Shu bazani tanlaymiz
USE doston_website_db;

-- ======================================================
-- 🔐 1. users (foydalanuvchilar jadvali)
-- Admin panelga kiruvchilar (adminlar, moderatorlar va h.k.)
-- ======================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ======================================================
--  2. projects (loihalar)
-- Sayt yangiliklari 
-- ======================================================
CREATE TABLE projects (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `description` TEXT,
    `image` VARCHAR(255),
    `link` VARCHAR(255),
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ======================================================
--  3. blog (blog postlar)
-- Sayt blog postlari
-- ======================================================
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    link VARCHAR(255) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO blogs (title, description, image, link) VALUES
('PHP vs Node.js: Qaysi biri yaxshiroq?', 
 'Ushbu maqolada PHP va Node.js ortasidagi farqlarni korib chiqamiz...',
 'https://via.placeholder.com/300x200', 
 '#');


INSERT INTO users (name, username, password)
VALUES ('Doston Davlatov', 'admin', '$2y$10$M7bOo5D228YqtxP1pUicGOYWtVryXknZUhTX1S2Mwjg3DtJzjEEJG');