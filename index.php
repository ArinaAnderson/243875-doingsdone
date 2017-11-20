<?php
               
date_default_timezone_set('Europe/Moscow');

require_once('functions.php');
require_once('templates/data.php');

$task = null;

if (isset($_GET['project_id'])) {
	$projectId = $_GET('project_id');
    
    if ($mainNavigation[$projectId]) {    //переданный идентификатор присутствует в массиве

	    $typeOftask = $mainNavigation[$projectId];
	    foreach ($tasks as $value) {
		    if ($value['type'] == $typeOftask) {
	            $task = $value; //присвоение нужной задачи (c нужным типом со всеми ее данными
	        }    
	    }
	} else { //переданный идентификатор не присутствует в массиве
        hrml_response_code(404);
	}
} elseif (!isset($_GET['project_id']) || $_GET('project_id') == 0) {    //показывать все задачи
    foreach ($tasks as $item) {
    	$task = $item;
    }
};

$pageContent = getTemplate('templates/index.php', ['tasks' => $tasks]);
$layoutOfPage = getTemplate('templates/layout.php', [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks
]);

print($layoutOfPage);
