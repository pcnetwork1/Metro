<?php

class Predavac
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, b.ime, a.iban, 
        b.prezime, b.oib, b.email, count(c.sifra) as ukupno
        from predavac a inner join osoba b  on a.osoba=b.sifra
        left join grupa c on a.sifra=c.predavac
        group by a.sifra, b.ime, a.iban, 
        b.prezime, b.oib, b.email 
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('

        select a.sifra, a.iban, b.ime, 
        b.prezime, b.oib, b.email
        from predavac a inner join osoba b  on a.osoba=b.sifra
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

        $izraz=$veza->prepare('insert into predavac 
        (osoba,iban) values 
        (:osoba,:iban)');
        $izraz->bindParam(':osoba',$zadnjaSifra);
        if(trim($_POST['iban'])===''){
            $izraz->bindValue(':iban', null, PDO::PARAM_NULL);
        }else{
            $izraz->bindParam(':iban',$_POST['iban']); 
        }
        $izraz->execute(); 
    
        
        $veza->commit();
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $veza->beginTransaction();
            $izraz=$veza->prepare('select osoba
            from predavac  
            where sifra=:sifra');
            $izraz->execute($_GET);

            $sifraosoba = $izraz->fetchColumn();

            $izraz=$veza->prepare('delete from predavac 
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
            from predavac  
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

    
        $izraz=$veza->prepare('update predavac 
        set iban=:iban
        where sifra=:sifra');
        $izraz->execute([
            'sifra' => $_POST['sifra'],
            'iban' => $_POST['iban']
        ]); 
    
        
        $veza->commit();
    }
}