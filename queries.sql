USE doingsdone_db;

INSERT INTO users SET email='ignat.v@gmail.com', password='ug0GdVMi'; 
INSERT INTO users SET email='kitty_93@li.ru', password='daecNazD'; 
INSERT INTO users SET email='warrior07@mail.ru', password='oixb3aL8';  

ALTER TABLE projects ADD user_id INT;

INSERT INTO projects SET name='Все', user_id=1; 
INSERT INTO projects SET name='Входящие', user_id=1;
INSERT INTO projects SET name='Учеба', user_id=1;
INSERT INTO projects SET name='Работа', user_id=1;
INSERT INTO projects SET name='Домашние дела', user_id=1;
INSERT INTO projects SET name='Авто', user_id=1;

ALTER TABLE tasks ADD user_id INT;
ALTER TABLE tasks ADD completed TINYINT(1); /* 0  или 1*/

INSERT INTO tasks SET name='Собеседование в IT компании', deadline='01.06.2017', project_id=4, user_id=1;
INSERT INTO tasks SET name='Выполнить тестовое задание', deadline='25.05.2018', project_id=4, user_id=1;
INSERT INTO tasks SET name='Сделать задание первого раздела', deadline='21.04.2018', project_id=3, user_id=1;
INSERT INTO tasks SET name='Встреча с другом', deadline='22.04.2018', project_id=2, user_id=1;
INSERT INTO tasks SET name='Купить корм для кота', deadline='01.06.2017', project_id=5, user_id=1;
INSERT INTO tasks SET name='Заказать пиццу', deadline='01.06.2017', project_id=5, user_id=1;





