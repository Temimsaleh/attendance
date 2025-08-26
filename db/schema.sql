-- إنشاء قاعدة البيانات (نفّذ هذا في phpMyAdmin أو MySQL)
CREATE DATABASE IF NOT EXISTS attendance_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE attendance_db;

-- جدول المستخدمين
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','employee') NOT NULL DEFAULT 'employee',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- جدول الحضور
CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  checkin_time DATETIME NOT NULL,
  checkout_time DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (employee_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- إنشاء حساب مدير افتراضي
-- عدّل البريد وكلمة المرور قبل الإنتاج
INSERT INTO users (name,email,password,role) VALUES
('المدير','admin@example.com', '$2y$10$Fqv3oN1b1Uo4kbb6o0qjzO1oR2R9Oqk9wz1r9e3YwYy2x6Rk0aZfG', 'admin');
-- كلمة المرور المشفرة أعلاه هي: admin123

-- حساب مدير افتراضي المعدّل
INSERT INTO users (name,email,password,role) VALUES
('المدير','hissensaleh1517@gmail.com', '$2b$12$.sTO/ZB9fPFDgrqsM8qT6.sCoZGpCWbDPj/j0gZWErr17P6SefyKi', 'admin');
