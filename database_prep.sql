-- If it is in the hosting website ignore the next line
-- CREATE DATABASE donict;

-- USE donict;

CREATE TABLE `users` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(250) NOT NULL,
    bio VARCHAR(250),
    points INT DEFAULT 0,
    uploads INT DEFAULT 0,
    is_admin BOOLEAN DEFAULT false
);
CREATE TABLE IF NOT EXISTS `test_list` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(200),
    `prepared_by` VARCHAR(200),
    `difficulity` VARCHAR(200),
    `link` VARCHAR(200),
    `taken_by` TEXT DEFAULT '[]'
);