CREATE DATABASE doings_done;
USE doingsdone;

CREATE TABLE users  (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR,
	date_checkin DATE,
	email CHAR(64),
	password CHAR(30),
	contacts CHAR(255)

);
INSERT INTO users SET email='ignat.v@gmail.com', password='ug0GdVMi'; 
INSERT INTO users SET email='kitty_93@li.ru', password='daecNazD'; 
INSERT INTO users SET email='warrior07@mail.ru', password='oixb3aL8';  


CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128)
);
INSERT INTO users SET name='Все'; 
INSERT INTO users SET name='Входящие';
INSERT INTO users SET name='Учеба';
INSERT INTO users SET name='Работа';
INSERT INTO users SET name='Домашние дела';
INSERT INTO users SET name='Авто';

CREATE TABLE tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128),
	dt_create DATE,
	dt_complete DATE,
	deadline DATE,
	file CHAR(255),
	project_id INT
);
INSERT INTO tasks SET name='Собеседование в IT компании', deadline='01.06.2017', project_id='4';
INSERT INTO tasks SET name='Выполнить тестовое задание', deadline='25.05.2018', project_id='4';
INSERT INTO tasks SET name='Сделать задание первого раздела', deadline='21.04.2018', project_id='3';
INSERT INTO tasks SET name='Встреча с другом', deadline='22.04.2018', project_id='2';
INSERT INTO tasks SET name='Купить корм для кота', deadline='01.06.2017', project_id='5';
INSERT INTO tasks SET name='Заказать пиццу', deadline='01.06.2017', project_id='5';

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX password ON users(password);

