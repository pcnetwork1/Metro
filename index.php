<?php
session_start();
//echo __DIR__;
// definiram basepath - apsolutnu putanju mog direktorija
define("BP",__DIR__ . DIRECTORY_SEPARATOR );
//echo BP;
//echo BP;
// prikaži sve greške
error_reporting(E_ALL);
ini_set("display_errors",1);

//navodim direktorije u kojima ću autoload datoteke
$t = implode(PATH_SEPARATOR,
            [
                BP . "model",
                BP . "controller"
            ]
            );
//print_r($t);
// učitanje svih klasa u navedenim direktorijima
set_include_path($t);
spl_autoload_register(function($klasa)
{
    $paths = explode(PATH_SEPARATOR, get_include_path());
    foreach($paths as $p){
        //echo $p . DIRECTORY_SEPARATOR . $klasa .'<br />';
        if(file_exists($p . DIRECTORY_SEPARATOR . $klasa. ".php")){
            include $p . DIRECTORY_SEPARATOR . $klasa. ".php";
            break;
        }
    }
    
});
App::start();