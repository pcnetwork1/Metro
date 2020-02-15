<?php

class SmjerController extends AutorizacijaController
{
    public function index()
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from smjer');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
        DIRECTORY_SEPARATOR . 'smjer' .
        DIRECTORY_SEPARATOR . 'index',[
            'podaci'=>$rezultati
        ]);
    }
}