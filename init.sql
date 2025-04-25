CREATE DATABASE IF NOT EXISTS eventdb;
USE eventdb;

-- Create tables
CREATE TABLE events (...);  -- Your existing table definition
CREATE TABLE users (...);   -- Your existing table definition

-- Grant privileges (ADD THESE LINES)
GRANT ALL PRIVILEGES ON eventdb.* TO 'user'@'%' IDENTIFIED BY 'password';
FLUSH PRIVILEGES;

-- Insert admin user
INSERT INTO users (username, password) 
VALUES ('admin', '$2y$10$BqTb8hA5xjVz7JKLZ7sZQOe6t7d0w8U1XfV7wYb1mZ0nQa1vL2DZG');