<?php              
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');


$show_complete_tasks = 0;
if (isset($_GET['show_completed'])) {
    $show_complete_tasks = intval($_GET['show_completed']);
    setcookie('show_completed', $show_complete_tasks, strtotime("+ 1 day"), "/");
    //header("Location: index.php");
} else {
    if (isset($_COOKIE['show_completed'])) {
        $show_complete_tasks =  intval($_COOKIE['show_completed']);
    }
}


$errors = []; 
$bodyClass = "";
$errorMessage = 'Заполните это поле';
$mistakeClass = ' form__input--error';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $required = ['name', 'project', 'date'];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $errors[] = $key;
        }
    }
    if (!count($errors)) {
        $taskNewArray = [
            'task' => htmlspecialchars($_POST['name']),
            'deadline' => date("d.m.Y", strtotime($_POST['date'])),
            'type' => htmlspecialchars($_POST['project']),
        ];
        

        if (isset($_FILES['preview']['name'])) { 
            $uploaddir = $_SERVER['DOCUMENT_ROOT'];
            $uploadfile = $uploaddir . "/" . basename($_FILES['preview']['name']);
            move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile);
            if (move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile)) {
                $taskNewArray['fileName'] = $_FILES['preview']['name'];
            } 
        }
        
        array_unshift($tasks, $taskNewArray);
    }
}

$formTaskContent = '';

if (isset($_GET['add']) || !empty($errors)) { 
    $bodyClass = 'overlay';
    $formTaskContent = getTemplate('templates/add.php', [
        'mistakeClass' => $mistakeClass,
        'errorMessage' => $errorMessage,
        'errors' => $errors,
        'mainNavigation' => $mainNavigation //для заполнения тега select в шаблоне формы
    ]);
}

$taskList = [];

if (isset($_GET['project_id'])) {  
    if (array_key_exists($_GET['project_id'], $mainNavigation)) {
        foreach ($tasks as $task) {
            if ($task['type'] === $mainNavigation[$_GET['project_id']] || $mainNavigation[$_GET['project_id']] === 'Все') {
                $taskList[] = $task;
            }
        }
    } else { 
        http_response_code(404); 
    }
} else  {   
    $taskList = $tasks;
}

$pageContent = getTemplate('templates/index.php', [
    'tasks' => $taskList,
    'show_complete_tasks' => $show_complete_tasks

]); 
$layoutOfPage = getTemplate('templates/layout.php',  [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks,
    'bodyClass' => $bodyClass,
    'formTask' => $formTaskContent

]);

print($layoutOfPage);