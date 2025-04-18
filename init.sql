CREATE DATABASE IF NOT EXISTS eventdb;
USE eventdb;

CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  event_date DATE NOT NULL,
  location VARCHAR(255) NOT NULL,
  category VARCHAR(50) NOT NULL,
  image VARCHAR(255)
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) 
VALUES ('admin', '$2y$10$BqTb8hA5xjVz7JKLZ7sZQOe6t7d0w8U1XfV7wYb1mZ0nQa1vL2DZG'); -- Password: admin123