<?php              
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
    } else { 
    	http_response_code(404); 
    }
} else  {   
    $taskList = $tasks;
}

$bodyClass = "";
if (isset($_GET['add'])) { 
    $bodyClass = 'overlay';
    $formTaskContent = getTemplate('templates/add.php', [
        'mistakeClassArray' => $mistakeClassArray,
        'errorMessageArray' => $errorMessageArray,
        'mainNavigation' => $mainNavigation //для заполнения тега select в шаблоне формы
    ]);
}


if ($_SERVER['REQUIRED_METHOD'] == 'POST') { 
    $required = ['name', 'project', 'date'];
    $mistakeClassArray = [];
    $errorMessageArray = [];
    $errors = [];
    foreach ($_POST as $key => $value) {
        $mistakeClassArray = [$key => ''];
        $errorMessageArray = [$key => ''];

        if (in_array($key, $required) && $value == '') {
            $errors[] = $key; 
            $mistakeClassArray[$key] = ' form__input--error'; 
            $errorMessageArray[$key] = 'Заполните это поле';
            
        }
    }
    if (!count($errors)) {
        $bodyClass = '';
        header ("Location: ../index.php"); //если нет ошибок - убираем окно формы И добавляем данные в массив
    
        if (isset($_FILES['preview']['name'])) { 
            $fileType = "." . $_FILES['preview']['type'];
            $res = move_uploaded_file($FILES['preview']['tmp-name'], $_SERVER['DOCUMENT_ROOT']); //сохраняем в корне проекта
        }
    
        $taskNewArray = [
            'task' => htmlspecialchars($_POST['name']),
            'deadline' => tmlspecialchars($_POST['date']),
            'type' => htmlspecialchars($_POST['project']),
            'fileName' => htmlspecialchars($_FILES['preview']['name']),
            'fileResolution' => htmlspecialchars($fileType)
        ];
        array_unshift($tasks, $taskNewArray);
    }
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