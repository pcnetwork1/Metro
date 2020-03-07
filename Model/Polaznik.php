<?php

class Polaznik
{

    public static function trazi($uvjet)
    {
        $uvjet='%'.$uvjet.'%';
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email, count(c.grupa) as ukupno
        from polaznik a inner join osoba b  on a.osoba=b.sifra
        left join clan c on a.sifra=c.polaznik
        where concat(b.ime, \' \', b.prezime, 
        \' \',ifnull(b.oib,\'\')) like :uvjet 
        group by a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email 
        
        ');
        $izraz->execute(['uvjet' => $uvjet]);
        return $izraz->fetchAll();
    }

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email, count(c.grupa) as ukupno
        from polaznik a inner join osoba b  on a.osoba=b.sifra
        left join clan c on a.sifra=c.polaznik
        group by a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email 
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, a.brojugovora, b.ime, 
        b.prezime, b.oib, b.email
        from polaznik a inner join osoba b  on a.osoba=b.sifra
        where a.sifra=:sifra');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('insert into osoba 
        (ime,prezime,oib,email) values 
        (:ime,:prezime,:oib,:email)');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'oib' => $_POST['oib'],
            'email' => $_POST['email']
        ]); 

        $zadnjaSifra = $veza->lastInsertId();

        $izraz=$veza->prepare('insert into polaznik 
        (osoba,brojugovora) values 
        (:osoba,:brojugovora)');
        $izraz->execute([
            'osoba' => $zadnjaSifra,
            'brojugovora' => $_POST['brojugovora']
        ]); 
    
        
        $veza->commit();
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $veza->beginTransaction();
            $izraz=$veza->prepare('select osoba
            from polaznik  
            where sifra=:sifra');
            $izraz->execute($_GET);

            $sifraosoba = $izraz->fetchColumn();

            $izraz=$veza->prepare('delete from polaznik 
            where sifra=:sifra');
            $izraz->execute($_GET);


            $izraz=$veza->prepare('delete from osoba 
            where sifra=:sifra');
            $izraz->execute(['sifra'=>$sifraosoba]);


            $veza->commit();
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('select osoba
            from polaznik  
            where sifra=:sifra');
            $izraz->execute([
                'sifra' => $_POST['sifra']
            ]);

            $sifraosoba = $izraz->fetchColumn();

        $izraz=$veza->prepare('update osoba 
        set ime=:ime, prezime=:prezime,
        oib=:oib,email=:email
        where sifra=:sifra');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'oib' => $_POST['oib'],
            'email' => $_POST['email'],
            'sifra' => $sifraosoba
        ]); 

    
        $izraz=$veza->prepare('update polaznik 
        set brojugovora=:brojugovora
        where sifra=:sifra');
        $izraz->execute([
            'sifra' => $_POST['sifra'],
            'brojugovora' => $_POST['brojugovora']
        ]); 
    
        
        $veza->commit();
    }
}