<?php
session_start();

define("BP",__DIR__ . DIRECTORY_SEPARATOR );
error_reporting(E_ALL);
ini_set("display_errors",1);

$t = implode(PATH_SEPARATOR,
            [
                BP . "Model",
                BP . "Controller"
            ]
            );
//print_r($t);

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
