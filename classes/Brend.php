<?php

class Brend extends SuperKlasa
{
    private $brendID;
    private $brend;

    //region Get i Set
    public function getBrendID()
    {
        return $this->brendID;
    }

    public function setBrendID($brendID)
    {
        $this->brendID = $brendID;
    }

    public function getBrend()
    {
        return $this->brend;
    }

    public function setBrend($brend)
    {
        $this->brend = $brend;
    }
    //endregion

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM brend";
        return parent::dohvatiSveSuper($upit);
    }
}