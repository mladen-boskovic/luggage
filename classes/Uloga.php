<?php

class Uloga extends SuperKlasa
{
    private $ulogaID;
    private $uloga;

    //region Get i Set
    public function getUlogaID()
    {
        return $this->ulogaID;
    }

    public function setUlogaID($ulogaID)
    {
        $this->ulogaID = $ulogaID;
    }

    public function getUloga()
    {
        return $this->uloga;
    }

    public function setUloga($uloga)
    {
        $this->uloga = $uloga;
    }
    //endregion

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM uloga";
        return parent::dohvatiSveSuper($upit);
    }
}