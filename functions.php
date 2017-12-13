<?php
function  getTemplate($templateFile, $someArray) {
    if ($templateFile) {
        ob_start();//включаем буфер
        extract($someArray);
        require_once($templateFile);
        return ob_get_clean();;
    } else {
        return ""; 
    } 
}
function countOfElements($tableOfElements, $typeOfProject) {
    $countOfAll = 0;
    $countOfElement = 0;
    foreach ($tableOfElements as $groups) {
        $countOfAll ++;
        foreach ($groups as $key => $value) {
            if (strtoupper($value) === strtoupper($typeOfProject)) {
                $countOfElement++;
            } 
        } 
    }
    if ($typeOfProject === "Все") {
        return $countOfAll;
    } else {
        return $countOfElement; 
    }
}
function deadlineCheck($dateOfDeadline) {
    $taskDeadlineTs = strtotime((string)$dateOfDeadline);
    $daysUntilDeadline = round(($taskDeadlineTs - time())/(3600*24), 0, PHP_ROUND_HALF_DOWN);
    if (!empty($dateOfDeadline) && ($daysUntilDeadline <= 0)) {
        return 1;
    } else {
        return 0;
    }
}
function searchUserByEmail($email, $users) {
    $result = false;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;   
}
function validateEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}
function classOfActive($nameOfLine) { //$_GEST[’nane']        
    $styleActiveMenuItem = "";
    if ($projectItem['name'] == $nameOfLine) {
        $styleActiveMenuItem = ' main-navigation__list-item--active';
    }
    return $styleActiveMenuItem;
}