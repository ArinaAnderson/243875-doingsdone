CREATE DATABASE doingsdone;
USE doingsdone;

CREATE TABLE users  (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR,
date_checkin DATE,
email CHAR(64),
password CHAR(30),
contacts CHAR(255)

);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128)
);

CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR(128),
dt_create DATE,
dt_complete DATE,
deadline DATE,
file CHAR(255),
project_id INT
);


CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX password ON users(password);

