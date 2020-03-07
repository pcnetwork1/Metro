<?php

class App
{
    public static function start()
    {
       $ruta = Request::getRuta();
        // echo $ruta;   

        $djelovi = explode('/',$ruta);

    // print_r($djelovi);

        $klasa='';
        if(!isset($djelovi[1]) || $djelovi[1]===''){
            $klasa='Index';
        }else{
            $klasa=ucfirst($djelovi[1]);
        }

        // $klasa= $klasa . 'Controller'; - duži način
        $klasa.='Controller';

        // echo $klasa;

        $funkcija='';
        if(!isset($djelovi[2]) || $djelovi[2]===''){
                $funkcija='index';
            }else{
                $funkcija=$djelovi[2];
        }




        if(class_exists($klasa) && method_exists($klasa,$funkcija)){
           

            $instanca = new $klasa();
            $instanca->$funkcija();
        }else{
            header('HTTP/1.0 404 Not Found');
            echo "Nažalost, tražena stranica se pogubila.";
            
        }


    }

    public static function config($kljuc)
    {
        $konfiguracija = include BP . 'konfiguracija.php';
    
        return $konfiguracija[$kljuc];
    }
}