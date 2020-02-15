<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('prijava',[
            'poruka'=>'Unesite pristupne podatke',
            'AdminID'=>''
        ]);
    }

    public function autorizacija()
    {
        if(!isset($_POST['AdminID']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('prijava',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'AdminID' =>''
            ]);
            return;
        }

        if(trim($_POST['AdminID'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('prijava',[
                'poruka'=>'Pristupni podaci obavezno',
                'AdminID'=>$_POST['AdminID']
            ]);
            return;
        }

        //$veza = new PDO('mysql:host=localhost;dbname=edunovapp20;charset=utf8',
        //'edunova','edunova');

        $veza = DB::getInstanca();

        	    //sql INJECTION PROBLEM
        //$veza->query('select lozinka from djelatnik 
        //              where AdminID=\'' . $_POST['AdminID'] . '\';');
        $izraz = $veza->prepare('select * from djelatnik 
                      where AdminID=:AdminID;');
        $izraz->execute(['AdminID'=>$_POST['AdminID']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'AdminID'=>$_POST['AdminID']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija AdminID i lozinka',
                'AdminID'=>$_POST['AdminID']
            ]);
            return;
        }
        unset($rezultat->lozinka);
        $_SESSION['djelatnik']=$rezultat;
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['djelatnik']);
        session_destroy();
        $this->index();
    }

    public function index()
    {
        $poruka='hello iz kontrolera';
        $kod=22;

       
        $this->view->render('pocetna',[
            'p'=>$poruka,
            'k'=>$kod]
        );


    }
    public function onama()
    {
        $this->view->render('onama');
    }

    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='PHP programiranje';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }

    public function test()
    {
     echo password_hash('e',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    } 
}