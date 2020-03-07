<?php

class PolaznikController extends AutorizacijaController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'polaznik' .
    DIRECTORY_SEPARATOR;


    public function trazi()
    {
        $this->view->render($this->viewDir . 'index',[
            'podaci'=>Polaznik::trazi($_GET['uvjet'])
           ]);
    }

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Polaznik::readAll()
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
        Polaznik::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Polaznik::delete()){
            header('location: /polaznik/index');
        }
        
    }


    public function promjena()
    {
        $polaznik = Polaznik::read($_GET['sifra']);
        if(!$polaznik){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['polaznik'=>$polaznik,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Polaznik::update();
        header('location: /polaznik/index');
    }

}