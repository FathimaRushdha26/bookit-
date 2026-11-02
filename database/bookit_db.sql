-- BookIt - Online Booking Management System
-- Import this file in phpMyAdmin (Import tab) or: mysql -u root < bookit_db.sql

CREATE DATABASE IF NOT EXISTS bookit_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bookit_db;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    category VARCHAR(60) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    duration_minutes INT NOT NULL DEFAULT 60,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    notes VARCHAR(255) DEFAULT NULL,
    status ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slot (service_id, booking_date, booking_time),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Demo accounts: admin@bookit.com / Admin@123   |   john@example.com / Customer@123
INSERT INTO users (name,email,phone,password,role) VALUES
('System Admin','admin@bookit.com','0771234567','$2y$10$OHggou3IVwRBLGP/rVzkfeTpHmAkBURJCG9eHx114e/1PDXt0pUwe','admin'),
('John Perera','john@example.com','0712345678','$2y$10$R6NIBahbZnXSiN6vP2YvsuMj7OKYHx2b1FQP8/Kwvhc4epAudf/1O','customer');

INSERT INTO services (name,category,description,price,duration_minutes) VALUES
('Haircut & Styling','Salon','Professional haircut and styling session.',1500.00,45),
('Full Body Massage','Spa','Relaxing 60 minute full body massage.',4500.00,60),
('Dental Check-up','Medical','General dental examination and cleaning.',3000.00,30),
('Car Wash & Detailing','Automotive','Interior and exterior detailing.',5000.00,90),
('Personal Training','Fitness','One-to-one gym training session.',2500.00,60),
('Photography Session','Studio','Studio portrait session with 10 edited photos.',8000.00,60);

INSERT INTO bookings (user_id,service_id,booking_date,booking_time,notes,status) VALUES
(2,1,DATE_ADD(CURDATE(),INTERVAL 2 DAY),'10:00:00','First visit','confirmed'),
(2,2,DATE_ADD(CURDATE(),INTERVAL 3 DAY),'14:00:00',NULL,'pending'),
(2,3,DATE_SUB(CURDATE(),INTERVAL 5 DAY),'09:00:00',NULL,'completed');
