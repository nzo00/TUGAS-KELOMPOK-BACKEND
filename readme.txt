-- Membuat database jika belum ada
CREATE DATABASE IF NOT EXISTS midproject_bncc;

-- Menggunakan database yang baru dibuat atau yang sudah ada
USE midproject_bncc;

-- Membuat tabel users jika belum ada
CREATE TABLE IF NOT EXISTS users (
    Id VARCHAR(10) PRIMARY KEY,          -- Kolom untuk ID pengguna
    first_name VARCHAR(50),              -- Kolom untuk nama depan
    last_name VARCHAR(50),               -- Kolom untuk nama belakang
    email VARCHAR(100),                  -- Kolom untuk email
    password VARCHAR(255),               -- Kolom untuk password
    bio TEXT                             -- Kolom untuk bio pengguna
);

-- Masukan data pengguna ke dalam tabel users
INSERT INTO users (Id, first_name, last_name, email, password, bio) 
VALUES ('A001', 'admin', 'BNCC', 'adminBNCC@gmail.com', '0192023a7bbd73250516f069df18b500', 'Hi my name is Admin, and I like backend development.');


