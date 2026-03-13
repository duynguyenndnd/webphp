CREATE DATABASE IF NOT EXISTS movie_db;
USE movie_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_year INT,
    genre VARCHAR(50),
    image_url VARCHAR(255),
    video_url VARCHAR(255), -- Lưu link URL hoặc đường dẫn tệp tải lên
    video_type ENUM('url', 'file') DEFAULT 'url',
    rating DECIMAL(3,1) DEFAULT 0.0,
    duration VARCHAR(20) DEFAULT '0h 0m',
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo tài khoản Admin mặc định (mật khẩu: admin123)
-- Lưu ý: Trong thực tế nên dùng password_hash()
INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin');
INSERT INTO users (username, password, role) VALUES ('user1', 'user123', 'user');

-- Dữ liệu mẫu phim
INSERT INTO movies (title, description, release_year, genre, image_url, video_url, video_type, rating, duration, is_featured) VALUES
('Inception', 'A thief who steals corporate secrets...', 2010, 'Sci-Fi', 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_.jpg', 'https://www.w3schools.com/html/mov_bbb.mp4', 'url', 8.8, '2h 28m', TRUE);