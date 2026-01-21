-- Alki Corp Blog - Demo Seed Data
-- Run this script to populate the database with test data for the SQLi demo
-- Usage: mysql -u root alkicorp < seed_demo_data.sql

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS alkicorp;
USE alkicorp;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    comment_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- Clear existing demo data (optional - uncomment if needed)
-- DELETE FROM comments;
-- DELETE FROM posts;
-- DELETE FROM users;

-- Insert demo users (plaintext passwords for vulnerable demo)
-- In real apps, these would be hashed with password_hash()
INSERT INTO users (username, password) VALUES
    ('admin', 'admin123'),
    ('johndoe', 'password123'),
    ('janesmith', 'qwerty456')
ON DUPLICATE KEY UPDATE username = username;

-- Insert demo posts
INSERT INTO posts (title, content, author_id) VALUES
    ('Welcome to Alki Corp Blog', 'This is our first blog post. We are excited to share updates about our company and projects.', 1),
    ('Security Best Practices', 'Always use strong passwords and keep your software updated. Security is everyone''s responsibility.', 1),
    ('Team Update', 'We have added new members to our development team. Welcome aboard!', 2)
ON DUPLICATE KEY UPDATE title = title;

-- Insert demo comments
INSERT INTO comments (post_id, comment_content) VALUES
    (1, 'Great first post! Looking forward to more updates.'),
    (1, 'Excited to follow along with the company news.'),
    (2, 'Very helpful security tips, thanks for sharing!'),
    (3, 'Welcome to the new team members!')
ON DUPLICATE KEY UPDATE comment_content = comment_content;

-- Verify data
SELECT 'Users:' AS '';
SELECT id, username, password FROM users;

SELECT 'Posts:' AS '';
SELECT id, title, author_id FROM posts;

SELECT 'Comments:' AS '';
SELECT id, post_id, LEFT(comment_content, 50) AS comment_preview FROM comments;
