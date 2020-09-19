<?php
require 'function.php';
require 'art.php';

awal:
echo $art;
echo $menu;
echo "Choose Menu = ";
$pilihan = trim(fgets(STDIN));
switch($pilihan){
    case "1":
        cls();
        echo $art;
        checkAddress();
        echo $ulang;
        $answer = trim(fgets(STDIN));
        if(strtolower($answer) === 'y'){
            cls();
            goto awal;
        }
    break;
    case "2": 
        cls();
        echo $art;
        checkBalance();
        echo $ulang;
        $answer = trim(fgets(STDIN));
        if(strtolower($answer) === 'y'){
            cls();
            goto awal;
        }
    break;
    default:
        echo "Menu tidak tersedia!";
}