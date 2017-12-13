CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE doingsdone;

CREATE TABLE users  (
id INT AUTO_INCREMENT PRIMARY KEY,
name TEXT,
date_checkin DATE,
email CHAR(64),
password CHAR(255),
contacts CHAR(255)

);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name TEXT,
    user_id INT
);

CREATE TABLE tasks (
id INT AUTO_INCREMENT PRIMARY KEY,
name TEXT,
dt_create DATE,
dt_complete DATE,
deadline DATE,
file CHAR(255),
user_id INT,
project_id INT,
completed TINYINT(1)
);

CREATE UNIQUE INDEX email ON users(email);

/*CREATE UNIQUE INDEX name ON projects(name);*/
