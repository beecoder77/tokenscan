<?php
require 'function.php';
require 'art.php';

awal:
echo $art;
echo $mainMenu;
echo "Choose Menu = ";
$pilihan = trim(fgets(STDIN));
switch($pilihan){
    case "1":
        cls();
        echo $art;
        echo $menuEtherScan;
        echo "Choose Menu = ";
        $pilihanEther = trim(fgets(STDIN));
        switch($pilihanEther){
            case "1":
                cls();
                echo $art;
                checkAddressETH();
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
                checkBalanceETH();
                echo $ulang;
                $answer = trim(fgets(STDIN));
                if(strtolower($answer) === 'y'){
                    cls();
                    goto awal;
                }
            break;
            default:
                cls();
                echo "Menu tidak tersedia!";
        }
    break;
    case "2": 
        cls();
        echo $art;
        checkBalanceBSC();
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