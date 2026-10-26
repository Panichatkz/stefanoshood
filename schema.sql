CREATE DATABASE IF NOT EXISTS stefanoshood CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE stefanoshood;

CREATE TABLE IF NOT EXISTS members (
    user VARCHAR(16) PRIMARY KEY,
    pass VARCHAR(255),
    INDEX(user(6))
);

CREATE TABLE IF NOT EXISTS messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    auth VARCHAR(16),
    recip VARCHAR(16),
    pm CHAR(1),
    time INT UNSIGNED,
    message VARCHAR(4096),
    INDEX(auth(6)),
    INDEX(recip(6))
);

CREATE TABLE IF NOT EXISTS friends (
    user VARCHAR(16),
    friend VARCHAR(16),
    INDEX(user(6)),
    INDEX(friend(6))
);

CREATE TABLE IF NOT EXISTS profiles (
    user VARCHAR(16) PRIMARY KEY,
    text VARCHAR(4096),
    INDEX(user(6))
);