<?php
class Proizvod
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select id, 
        naziv, barcode, kategorija, racun from proizvod where id>1');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();

        $izraz=$veza->prepare('insert into proizvod 
        (naziv,barcode,kategorija) values 
        (:naziv,:barcode,:kategorija)');
        $izraz->execute([
            'naziv' => $_POST['naziv'],
            'barcode' => $_POST['barcode'],
            'kategorija' => $_POST['kategorija'],
        ]); 
}
}
