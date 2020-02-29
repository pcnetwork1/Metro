<?php

class IndexController extends Controller
{

    public function prijavak()
    {
        $this->view->render('prijavak',[
            'poruka'=>'Unesite pristupne podatke',
            'email'=>''
        ]);
    }

    public function autorizacija()
    {
        if(!isset($_POST['email']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('prijavak',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        if(trim($_POST['email'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('prijavak',[
                'poruka'=>'Pristupni podaci obavezno',
                'email'=>$_POST['email']
            ]);
            return;
        }
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from kupac 
                      where email=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('prijavak',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }
        unset($rezultat->lozinka);
        $_SESSION['operater']=$rezultat;
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['operater']);
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

    public function prijava()
    {
        $this->view->render('prijava');
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

    public function admin()
    {
        $this->view->render('admin',[
            'poruka'=>'Unesite pristupne podatke',
            'email'=>''
        ]);
    }

    public function autorizacijaa()
    {
        if(!isset($_POST['email']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('admin',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        if(trim($_POST['email'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('admin',[
                'poruka'=>'Pristupni podaci obavezno',
                'email'=>$_POST['email']
            ]);
            return;
        }
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from djelatnik 
                      where email=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
        if($rezultat==null){
            $this->view->render('admin',[
                'poruka'=>'Ne postojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('admin',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }
        unset($rezultat->lozinka);
        $_SESSION['operater']=$rezultat;
        $npc = new NadzornaplocaController();
        $npc->index();
    }
}