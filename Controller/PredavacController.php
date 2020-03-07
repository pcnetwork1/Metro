<?php

class PredavacController extends AutorizacijaController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'predavac' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Predavac::readAll()
        ]);
        
     
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }


    public function dodajnovi()
    {
        //prvo dođu sve silne kontrole
        Predavac::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Predavac::delete()){
            header('location: /predavac/index');
        }
        
    }


    public function promjena()
    {
        $predavac = Predavac::read($_GET['sifra']);
        if(!$predavac){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['predavac'=>$predavac,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Predavac::update();
        header('location: /predavac/index');
    }

}