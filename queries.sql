USE doingsdone;

INSERT INTO users SET name='Игнат', email='ignat.v@gmail.com', password='$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'; 
INSERT INTO users SET name='Леночка', email='kitty_93@li.ru', password='$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'; 
INSERT INTO users SET name='Руслан', email='warrior07@mail.ru', password='$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW';  

INSERT INTO projects SET name='Все', user_id=1; 
INSERT INTO projects SET name='Входящие', user_id=1;
INSERT INTO projects SET name='Учеба', user_id=1;
INSERT INTO projects SET name='Работа', user_id=1;
INSERT INTO projects SET name='Домашние дела', user_id=1;
INSERT INTO projects SET name='Авто', user_id=1;

INSERT INTO tasks SET name='Собеседование в IT компании', deadline='2017.06.01', user_id=1, project_id=4, completed=0;
INSERT INTO tasks SET name='Выполнить тестовое задание', deadline='2018.05.25', user_id=1, project_id=4, completed=0;
INSERT INTO tasks SET name='Сделать задание первого раздела', deadline='2018.04.21', user_id=1, project_id=3, completed=1;
INSERT INTO tasks SET name='Встреча с другом', deadline='2018.04.22', user_id=1, project_id=2, completed=0;
INSERT INTO tasks SET name='Купить корм для кота', user_id=1, project_id=5, completed=0;
INSERT INTO tasks SET name='Заказать пиццу', user_id=1, project_id=5, completed=0;


SELECT name FROM projects WHERE user_id = 1; /*получить список из всех проектов для одного пользователя*/
SELECT * FROM tasks WHERE project_id = 5; /*получить список из всех задач для одного проекта*/
UPDATE tasks SET completed=1 WHERE id=4; /*пометить задачу как выполненную*/
UPDATE tasks SET name='Встреча с котом' WHERE id=5; /*получить все задачи для завтрашнего дня*/
SELECT MIN(deadline) FROM tasks WHERE deadline>CURDATE() AND completed=0; /*обновить название задачи по её идентификатору*/