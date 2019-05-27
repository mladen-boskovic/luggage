<?php

class Odgovor extends SuperKlasa
{
    private $odgovorID;
    private $odgovor;
    private $pitanjeID;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getOdgovorID()
    {
        return $this->odgovorID;
    }

    public function setOdgovorID($odgovorID)
    {
        $this->odgovorID = $odgovorID;
    }

    public function getOdgovor()
    {
        return $this->odgovor;
    }

    public function setOdgovor($odgovor)
    {
        $this->odgovor = $odgovor;
    }

    public function getPitanjeID()
    {
        return $this->pitanjeID;
    }

    public function setPitanjeID($pitanjeID)
    {
        $this->pitanjeID = $pitanjeID;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM odgovor";
        return parent::dohvatiSveSuper($upit);
    }

    public function dohvatiOdgovore()
    {
        $upit = "SELECT * FROM odgovor WHERE pitanjeID = :pitanjeID";
        $podaci = ["pitanjeID" => $this->pitanjeID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetchAll();
    }
}