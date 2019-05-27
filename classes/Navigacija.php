<?php

class Navigacija extends SuperKlasa
{
    private $navigacijaID;
    private $navigacija;
    private $href;
    private $roditelj;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getNavigacijaID()
    {
        return $this->navigacijaID;
    }

    public function setNavigacijaID($navigacijaID)
    {
        $this->navigacijaID = $navigacijaID;
    }

    public function getNavigacija()
    {
        return $this->navigacija;
    }

    public function setNavigacija($navigacija)
    {
        $this->navigacija = $navigacija;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getRoditelj()
    {
        return $this->roditelj;
    }

    public function setRoditelj($roditelj)
    {
        $this->roditelj = $roditelj;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM navigacija";
        return parent::dohvatiSveSuper($upit);
    }

    public function dohvatiPoRoditelju()
    {
        $upit = "SELECT * FROM navigacija WHERE roditelj = :roditelj";
        $podaci = ["roditelj" => $this->roditelj];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetchAll();
    }

    public function dohvatiPrviRed()
    {
        $upit = "SELECT * FROM navigacija WHERE roditelj = 0";
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }
}