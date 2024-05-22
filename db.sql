-- Projects table
CREATE TABLE projects (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    project_name VARCHAR(30) NOT NULL,
    file_path TEXT NOT NULL,
    project_detail VARCHAR(250) NOT NULL,
    project_time INT NOT NULL,
    likes INT DEFAULT 0,
    comments INT DEFAULT 0,
    reports INT DEFAULT 0,
    liked_by TEXT DEFAULT '[]',
    reported_by TEXT DEFAULT '[]',
    user_id INT NOT NULL,
    project_unique_identifier TEXT,
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

-- Test list

CREATE TABLE IF NOT EXISTS `test_list` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(200),
    `prepared_by` VARCHAR(200),
    `difficulty` VARCHAR(200),
    -- `link` VARCHAR(200),
    `taken_by` TEXT DEFAULT '[]',
    test_list_unique_identifier TEXT NOT NULL
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
    `subject` VARCHAR(50),
    test_list_id INT NOT NULL,
    FOREIGN KEY (test_list_id) REFERENCES test_list(id) ON DELETE CASCADE
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
    comment_unique_identifier TEXT NOT NULL,
);

-- Reports table

CREATE TABLE reports (
    report_id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE,
    R1 INT DEFAULT 0,
    R2 INT DEFAULT 0,
    R3 INT DEFAULT 0,
    R4 INT DEFAULT 0
);

-- Notifications table

CREATE TABLE notifications (
    notify_id INT PRIMARY KEY AUTO_INCREMENT,
    notify_title TEXT NOT NULL,
    notify_message TEXT NOT NULL,
    notify_to TEXT NOT NULL,
    notify_time INT NOT NULL
);