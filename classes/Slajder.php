<?php

class Slajder extends SuperKlasa
{
    private $slajderID;
    private $src;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getSlajderID()
    {
        return $this->slajderID;
    }

    public function setSlajderID($slajderID)
    {
        $this->slajderID = $slajderID;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function setSrc($src)
    {
        $this->src = $src;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM slajder";
        return parent::dohvatiSveSuper($upit);
    }
}