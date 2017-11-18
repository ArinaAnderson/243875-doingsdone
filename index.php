<?php
               
date_default_timezone_set('Europe/Moscow');

require_once('functions.php');
require_once('templates/data.php');

$pageContent = getTemplate('templates/index.php', ['tasks' => $tasks]);
$layoutOfPage = getTemplate('templates/layout.php', [
    'content' => $pageContent,
    'siteTitle' => 'Дела в порядке',
    'mainNavigation' => $mainNavigation,
    'tasks' => $tasks
]);

print($layoutOfPage);
