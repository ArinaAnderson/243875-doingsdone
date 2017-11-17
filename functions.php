<?php
function  getTemplate($templateFile, $someArray) {
    if($templateFile) {
        ob_start();//включаем буфер
        extract($someArray);
        require_once($templateFile);
        $outputOfTemplate =  ob_get_contents();
        return $outputOfTemplate;
    } else {
        return ""; //если нет указанного шаблона, вывести пустую строку
    } 
};


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
};

 function classOfActive($numberOfLine) {
    static $keyCount = 0;
    $keyCount++;
                        
    $styleActiveMenuItem = "";
    if ($keyCount === $numberOfLine) {
        $styleActiveMenuItem = ' main-navigation__list-item--active';
    }; 
    return $styleActiveMenuItem;
}