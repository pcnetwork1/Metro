<?php

class Request
{
    public static function getRuta()
    {
        $ruta='';
        if(isset($_SERVER['REDIRECT_PATH_INFO'])){
            $ruta=$_SERVER['REDIRECT_PATH_INFO'];
        }else if(isset($_SERVER['PATH_INFO'])){
            $ruta=$_SERVER['PATH_INFO'];
        }else{
            $ruta='/';
        }
        return $ruta;
    }
}