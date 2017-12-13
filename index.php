<?php 
session_start();       
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');
require_once('templates/userdata.php');
require_once('init.php');


$errors = ['login' => [], 'add' => [], 'register' => []];;

$errorMessage = 'Заполните это поле';
$mistakeClass = ' form__input--error';

$sqlUsers = "SELECT * FROM users";
$resultUsers = mysqli_query($link, $sqlUsers);
if ($resultUsers) {
    $usersList = mysqli_fetch_all($resultUsers, MYSQLI_ASSOC);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    $requiredFields = [
        'login' => ['email', 'password', 'wrong_password'],
        'add' => ['name', 'project', 'date'],
        'register' => ['email', 'password', 'name']
    ];
    
    $action = $_POST['action'];
    unset($_POST['action']);

    foreach ($_POST as $field => $value) {
        if (in_array($field, $requiredFields[$action]) && empty($value)) {
            $errors[$action][] = $field;
        } else {
            if ($field == 'email' && (!validateEmail($value) || in_array($value, $usersList)))  {
                $errors[$action][] = $field;
            }
            if ($field == 'project' && !in_array($value, $projectsList)) {
                $errors[$action][] = $field;
            }
        }
    }
    $user = [];
    if (empty($errors[$action])) {
        switch ($action) {
            case 'login' :
                $user = searchUserByEmail($_POST['email'], $usersList);
                if (!$user || !password_verify($_POST['password'], $user['password'])) {
                    $errors[$action][] = 'wrong_password';
                } else {
                    $_SESSION['user'] = $user;
                    header("Location: /index.php");
                }
            break;

            case 'add' :
                if (isset($_FILES['preview']['name'])) { 
                    $uploaddir = $_SERVER['DOCUMENT_ROOT'];
                    $uploadfile = $uploaddir . "/" . basename($_FILES['preview']['name']);
                    move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile);
                    if (move_uploaded_file($_FILES['preview']['tmp_name'], $uploadfile)) {
                        $taskNewFile = $_FILES['preview']['name'];
                    } 
                }
                $taskNewName = htmlspecialchars($_POST['name']);
                $taskDateCreate = date("Y.m.d");
                $taskNewDeadline = date("Y.m.d", strtotime($_POST['date']));
                
                $taskNewProject = htmlspecialchars($_POST['project']);
                
                $sqlTaskAdd = "INSERT INTO tasks SET name='$taskNewName', dt_create = '$taskDateCreate', deadline='$taskNewDeadline', user_id='$userId', project_id='$taskNewProject', completed='0'";
                $resultTaskAdd = mysqli_query($link, $sqlTaskAdd);
            break;

            case 'register' :
                $userNewName = htmlspecialchars($_POST['name']);
                $userNewEmail = htmlspecialchars($_POST['email']);
                $userNewPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $sqlUserAdd = "INSERT INTO users SET name='$userNewName', email='$userNewEmail', password = '$userNewPassword' ";
                $resultUserAdd = mysqli_query($link, $sqlUserAdd);
                
        }
    }
}

$pageContent = '';
$formEnterContent = '';
$formTaskContent = '';


if (isset($_SESSION['user'])) {
    $userId = $_SESSION['user']['id']; 
    $taskArray = [];
    $taskFiltered = [];
    $styleActiveMenuItem = "";
    
    $sqlProjects = "SELECT id, name FROM projects WHERE name = 'Все' OR user_id = '$userId'"; 
    $resultProjects = mysqli_query($link, $sqlProjects);
    if ($resultProjects) {
    $projectsList = mysqli_fetch_all($resultProjects, MYSQLI_ASSOC);
    } //check for error

    
    
    $sqlTasks = "SELECT tasks.*, projects.name as project_name FROM tasks   JOIN projects ON tasks.project_id=projects.id WHERE tasks.user_id = '$userId'";
    $resultTasks = mysqli_query($link, $sqlTasks);
    if ($resultTasks) {
        $taskArray =  mysqli_fetch_all($resultTasks, MYSQLI_ASSOC);
    }
 
    if (isset($_GET['project_name'])) {
        $projectId = $_GET['project_name'];
        foreach ($projectsList as $project) {
            if (in_array($_GET['project_name'], $project)) {
                foreach ($taskArray as $task) {
                    if ($task['project_name'] == $_GET['project_name'] || $_GET['project_name'] == 'Все' ) {
                        $taskFiltered[] = $task;
                    }
                }
                break;
            } else { 
            http_response_code(404); 
            }
        } 
    } else {
        $taskFiltered = $taskArray;
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
            'projectsList' => $projectsList 
        ]);
    }
    
    $pageContent = getTemplate('templates/index.php', [
        'taskArray' => $taskArray,
        'taskFiltered' => $taskFiltered,
        'show_complete_tasks' => $show_complete_tasks,
        'link' => $link,
        'checkedTask' => $checkedTask
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
if (isset($_GET['register'])) {
    $pageContent = getTemplate('templates/register.php', [
        'mistakeClass' => $mistakeClass,
        'errors' => $errors['register']
    ]);
} 

$layoutOfPage = getTemplate('templates/layout.php',  [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks,
    'formTask' => $formTaskContent,
    'formEnter' => $formEnterContent,
    'projectsList' => $projectsList,
    'usersList' => $usersList,
    'userId' => $userId,
    'taskArray' => $taskArray,
    'taskFiltered' => $taskFiltered,
    'projectList' => $projectList,
    'styleActiveMenuItem' => $styleActiveMenuItem,
    'link' => $link
]);
 
print($layoutOfPage);