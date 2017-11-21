<?php
//echo '<pre>'; var_dump($_SERVER); echo '</pre>';               
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');
 
$taskList = [];

if (isset($_GET['project_id'])) {  
    if (array_key_exists($_GET['project_id'], $mainNavigation)) {
        foreach ($tasks as $task) {
            if ($task['type'] === $mainNavigation[$_GET['project_id']] || $mainNavigation[$_GET['project_id']] === 'Все') {
                $taskList[] = $task;
            }
        }
    } else { //переданный идентификатор не присутствует в массиве
    	http_response_code(404);
        var_dump(http_response_code()); // для проверки, но в Develop tools все равно 200
    }
} else  {    //параметр не задан
    $taskList = $tasks;
}

$pageContent = getTemplate('templates/index.php', [
    'tasks' => $taskList
]); 
$layoutOfPage = getTemplate('templates/layout.php',  [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks

]);

print($layoutOfPage);

/*
$taskList = [];


if (isset($_GET['project_id']) && !($mainNavigation[$_GET['project_id']] == 'Все')) {
$projectId = $_GET['project_id']; //!!!
    
    if ($mainNavigation[$projectId]) {    //переданный идентификатор присутствует в массиве
        $typeOftask = $mainNavigation[$projectId];
        foreach ($tasks as $task) {
            if ($task['type'] == $typeOftask) {
                $taskList[] = $task; //присвоение нужной задачи (c нужным типом со всеми ее данными
            }    
        }
    } else { //переданный идентификатор не присутствует в массиве
        http_response_code(404);
    }
} else  {    //показывать все задачи
    $taskList = $tasks;
};

$pageContent = getTemplate('templates/index.php', [
'tasks' => $taskList
]); 
$layoutOfPage = getTemplate('templates/layout.php', [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks,
    'tasklist' => $taskList,
    'task' => $task

]);

print($layoutOfPage);*/

