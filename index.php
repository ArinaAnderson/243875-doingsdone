<?php 
session_start();       
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');
require_once('templates/userdata.php');
require_once('init.php');






$errors = ['login' => [], 'add' => []];;

$errorMessage = 'Заполните это поле';
$mistakeClass = ' form__input--error';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    $requiredFields = [
        'login' => ['email', 'password', 'wrong_password'],
        'add' => ['name', 'project', 'date']
    ];
    
    $action = $_POST['action'];
    unset($_POST['action']);

    foreach ($_POST as $field => $value) {
        if (in_array($field, $requiredFields[$action]) && empty($value)) {
            $errors[$action][] = $field;
        } else {
            if ($field == 'email' && !validateEmail($value)) {
                $errors[$action][] = $field;
            }
            if ($field == 'project' && !in_array($value, $mainNavigation)) {
                $errors[$action][] = $field;
            }
        }
    }

    if (empty($errors[$action])) {
        switch ($action) {
            case 'login' :
                $user = searchUserByEmail($_POST['email'], $users);
                if (!$user || !password_verify($_POST['password'], $user['password'])) {
                    $errors[$action][] = 'wrong_password';
                } else {
                    $_SESSION['user'] = $user;
                    header("Location: /index.php");
                }
            break;
            case 'add' :
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
            break;
        }
    }
}

$pageContent = '';
$formEnterContent = '';
$formTaskContent = '';

if (isset($_SESSION['user'])) {
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

    $show_complete_tasks = 0;
    if (isset($_GET['show_completed'])) {
        $show_complete_tasks = intval($_GET['show_completed']);
        setcookie('show_completed', $show_complete_tasks, strtotime("+ 1 day"), "/");
    } else {
        if (isset($_COOKIE['show_completed'])) {
            $show_complete_tasks =  intval($_COOKIE['show_completed']);
        }
    }

    if (isset($_GET['add']) || !empty($errors['add'])) {
        $formTaskContent = getTemplate('templates/add.php', [
            'mistakeClass' => $mistakeClass,
            'errorMessage' => $errorMessage,
            'errors' => $errors,
            'mainNavigation' => $mainNavigation 
        ]);
    }
    
    $pageContent = getTemplate('templates/index.php', [
        'tasks' => $taskList,
        'show_complete_tasks' => $show_complete_tasks
    ]);


} else {
    if (isset($_GET['login']) || !empty($errors['login'])) {
        $formEnterContent = getTemplate('templates/auth_form.php', [
            'mistakeClass' => $mistakeClass,
            'errors' => $errors['login']
        ]); 
    }


    $pageContent = getTemplate('templates/guest.php', []);
}
if (isset($_GET['logout'])) {
    
    header("Location: /logout.php");
}
  
$layoutOfPage = getTemplate('templates/layout.php',  [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks,
    'formTask' => $formTaskContent,
    'formEnter' => $formEnterContent,
    'users' => $users,
]);
 
print($layoutOfPage);