<?php              
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');

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
        if (isset($_FILES['preview']['name'])) { 
            $fileType = "." . $_FILES['preview']['type'];
            $res = move_uploaded_file($FILES['preview']['tmp-name'], $_SERVER['DOCUMENT_ROOT']); //сохраняем в корне проекта
        }
        
        $dateInputString = "" . ($_POST['date']);
        $dateInputTimeMark = strtotime($dateInputString);
        $dateForm = date("d.m.Y", $dateInputTimeMark);
        $taskNewArray = [
            'task' => htmlspecialchars($_POST['name']),
            'deadline' => htmlspecialchars($dateForm),
            'type' => htmlspecialchars($_POST['project']),
            'fileName' => htmlspecialchars($_FILES['preview']['name']),
            'fileResolution' => htmlspecialchars($fileType)
        ];
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
    'tasks' => $taskList
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