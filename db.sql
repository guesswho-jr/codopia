-- Projects table
CREATE TABLE projects (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    project_name VARCHAR(30) NOT NULL,
    file_path TEXT NOT NULL,
    project_detail VARCHAR(250) NOT NULL,
    -- project_time DATETIME DEFAULT CURRENT_TIME,
    project_time INT NOT NULL,
    likes INT DEFAULT 0,
    liked_by TEXT DEFAULT '[]',
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Events table
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) UNIQUE NOT NULL,
    event_desc TEXT NOT NULL,
    xp INT NOT NULL,
    deadline DATETIME NOT NULL,
    accepts INT DEFAULT 0,
    accepted_by TEXT DEFAULT '[]'
);

-- Admins table
CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(200) NOT NULL,
    username VARCHAR(100) UNIQUE NOT NULL,
    category VARCHAR(20) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Feedbacks table
CREATE TABLE feedbacks (
    feedback_id INT PRIMARY KEY AUTO_INCREMENT,
    feedback_body TEXT NOT NULL,
    feedback_time INT NOT NULL,
    bug VARCHAR(1) DEFAULT 0,
    rating TEXT DEFAULT "Not rated",
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tests table

CREATE TABLE if NOT EXISTS tests (
    test_id INT PRIMARY KEY AUTO_INCREMENT,
    question VARCHAR(300),
    answer VARCHAR(1),
    a VARCHAR(300), 
    b VARCHAR(300),
    c VARCHAR(300),
    d VARCHAR(300),
    `subject` VARCHAR(50)
);

-- Comments table

CREATE TABLE comments (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    comment_text TEXT NOT NULL,
    comment_time TEXT NOT NULL,
    comment_likes INT DEFAULT 0,
    comment_liked_by TEXT DEFAULT '[]',
    comment_project_id INT NOT NULL,
    FOREIGN KEY (comment_project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    comment_user_id INT NOT NULL,
    FOREIGN KEY (comment_user_id) REFERENCES users(id) ON DELETE CASCADE
);