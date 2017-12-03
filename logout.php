<?php 
session_start();       
date_default_timezone_set('Europe/Moscow');
 
require_once('functions.php');
require_once('templates/data.php');
require_once('templates/userdata.php');


unset($_SESSION['user']);
header("Location: /index.php");
