<?php

class OperaterController extends AdminController
{
    public function index()
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from djelatnik');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
     DIRECTORY_SEPARATOR . 'djelatnik' .
     DIRECTORY_SEPARATOR . 'index',[
         'podaci'=>$rezultati
     ]);
    }
}