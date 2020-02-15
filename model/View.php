<?php

class View
{
    private $layout;

    public function __construct($layout='predlozak')
    {
     $this->layout=$layout;   
    }

    public function render($stranica,$parametri=[])
    {
        ob_start(); //ne šalji prema klijentu, nego bufferiraj
        extract($parametri);
        include BP . 'view' . DIRECTORY_SEPARATOR 
        . $stranica . '.phtml';
        $sadrzaj = ob_get_clean(); //sve što si skupio dodjeli varijabli $sadrzaj

        include BP . 'view' . DIRECTORY_SEPARATOR 
        . $this->layout . '.phtml';
    }

}