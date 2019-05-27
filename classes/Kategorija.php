<?php

class Kategorija extends SuperKlasa
{
    private $kategorijaID;
    private $kategorija;

    //region Get i Set
    public function getKategorijaID()
    {
        return $this->kategorijaID;
    }

    public function setKategorijaID($kategorijaID)
    {
        $this->kategorijaID = $kategorijaID;
    }

    public function getKategorija()
    {
        return $this->kategorija;
    }

    public function setKategorija($kategorija)
    {
        $this->kategorija = $kategorija;
    }
    //endregion

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM kategorija";
        return parent::dohvatiSveSuper($upit);
    }
}