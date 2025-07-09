DROP DATABASE IF EXISTS textchat;
CREATE DATABASE textchat;

USE textchat;

CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(50),
    password VARCHAR(50)
);

CREATE TABLE messages (
    messageID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    message VARCHAR(250) NOT NULL,
    FOREIGN KEY (userID) REFERENCES users(userID)
);

INSERT INTO users (userName, password)
VALUES ('admin', 'password');
