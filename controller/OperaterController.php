<?php

class OperaterController extends AdminController
{
    public function index()
    {

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from operater');
        $izraz->execute();
        $rezultati = $izraz->fetchAll();

        $this->view->render('privatno' . 
     DIRECTORY_SEPARATOR . 'operater' .
     DIRECTORY_SEPARATOR . 'index',[
         'podaci'=>$rezultati
     ]);
    }
}