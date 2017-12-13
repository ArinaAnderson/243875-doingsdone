<?php 
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');

//error_reporting(0);
$link = mysqli_connect('89.108.98.195', 'root', 'ArinaAnderson123!', 'doingsdone');
if (!$link) {
    $mistake = mysqli_connect_error();
    print getTemplate('templates/error.php', ['mistake' => $mistake]);
    die();
}

//error_reporting(-1);
mysqli_set_charset($link, "utf8");