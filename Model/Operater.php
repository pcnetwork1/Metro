<?php

class Operater
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id, 
        ime, prezime, uloga, email, aktivan from operater where id>1');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id, 
        ime, prezime, uloga, email from operater
        where id=:id');
        $izraz->execute(['id'=>$id]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into operater 
        (email,lozinka,ime,prezime,uloga) values 
        (:email,:lozinka,:ime,:prezime,:uloga)');
        unset($_POST['lozinkaponovo']);
        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $izraz->execute($_POST);
        /* NAČIN 2
        $izraz->execute([
            'email' => $_POST['email'],
            'lozinka' => $_POST['lozinka'],
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'uloga' => $_POST['uloga'],
        ]);
                */
    }


    //nije osnovno - Anita ovo ne trebaš u prvom laufu učiti
    public static function registrirajnovi()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into operater 
        (email,lozinka,ime,prezime,uloga,aktivan,sessionid) values 
        (:email,:lozinka,:ime,:prezime,:uloga,false,:sessionid)');
        unset($_POST['lozinkaponovo']);

        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $_POST['sessionid'] = session_id();
        $_POST['uloga'] = 'oper';
        //print_r($_POST);

        $izraz->execute($_POST);
        $headers = "From: Edunova APP <cesar@lin39.mojsite.com>\r\n";
        $headers .= "Reply-To: Edunova APP <cesar@lin39.mojsite.com>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($_POST['email'],'Završi registraciju na Edunova APP',
                '<a href="' . App::config('url') . 
                'index/zavrsiregistraciju?id=' . $_POST['sessionid'] . '">Završi</a>', $headers);
               
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from operater where id=:id');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update operater 
        set email=:email,ime=:ime,
        prezime=:prezime,uloga=:uloga where id=:id');
        $izraz->execute($_POST);
    }

    //nije osnovno - Anita ovo ne trebaš u prvom laufu učiti
    public static function zavrsiregistraciju($id){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update operater 
        set aktivan=true where sessionid=:sessionid');
        $izraz->execute(['sessionid'=>$id]);
    }
}