<?php

class Baza
{
    private $host;
    private $baza;
    private $username;
    private $password;

    private $konekcija;
    private static $instanca;

    private function __construct()
    {
        $this->host = "localhost";
        $this->baza = "php2sajt1baza";
        $this->username = "root";
        $this->password = "";

        $this->connect();
    }

    public static function instanca()
    {
        if(self::$instanca == null){
            self::$instanca = new Baza();
        }
        return self::$instanca;
    }

    private function connect()
    {
        try
        {
            $this->konekcija = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->baza . ";charset=utf8", $this->username, $this->password);
            $this->konekcija -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->konekcija -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            echo "Konekcija sa bazom nije uspela: " . $e->getMessage();
        }
    }

    public function izvrsiSelect($upit, $podaci = null)
    {
        $priprema = $this->konekcija->prepare($upit);
        try
        {
            if($podaci == null)
            {
                $priprema->execute();
            }
            else
            {
                $priprema->execute($podaci);
            }
            return $priprema;
        }
        catch (PDOException $e)
        {
            echo "Došlo je do greške: " . $e->getMessage();
        }
    }

    public function izvrsiInsertUpdateDelete($upit, $podaci)
    {
        $priprema = $this->konekcija->prepare($upit);
        try
        {
            $priprema->execute($podaci);
            return $priprema;
        }
        catch (PDOException $e)
        {
			return;
            //echo "Došlo je do greške: " . $e->getMessage();
        }
    }
}