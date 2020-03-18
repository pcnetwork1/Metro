<?php
class KatalogController extends Controller
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'Katalog' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Proizvod::readAll()
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
        Proizvod::create();
        $this->index();
    }

}