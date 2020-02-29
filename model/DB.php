<?php
//ovo je singleton klasa https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
class DB extends PDO
{
    private static $instanca;

    public function __construct($db)
    {
        $dsn = 'mysql:host=' . $db['server'] . 
        ';dbname=' . $db['baza'] . ';charset=utf8';
        parent::__construct($dsn,$db['korisnik'],$db['lozinka']);

        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    }

    public static function getInstanca()
    {
        if(is_null(self::$instanca)){
            self::$instanca=new self(APP::config('db'));
        }
        return self::$instanca;
    }


}