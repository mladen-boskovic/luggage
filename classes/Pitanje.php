<?php

class Pitanje extends SuperKlasa
{
    private $pitanjeID;
    private $pitanje;
    private $aktivno;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getPitanjeID()
    {
        return $this->pitanjeID;
    }

    public function setPitanjeID($pitanjeID)
    {
        $this->pitanjeID = $pitanjeID;
    }

    public function getPitanje()
    {
        return $this->pitanje;
    }

    public function setPitanje($pitanje)
    {
        $this->pitanje = $pitanje;
    }

    public function getAktivno()
    {
        return $this->aktivno;
    }

    public function setAktivno($aktivno)
    {
        $this->aktivno = $aktivno;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM pitanje";
        return parent::dohvatiSveSuper($upit);
    }

    public function dohvatiAktivnaPitanja(){
        $upit = "SELECT * FROM pitanje WHERE aktivno = 1";
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }
}