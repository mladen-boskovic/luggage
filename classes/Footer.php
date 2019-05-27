<?php

class Footer extends SuperKlasa
{
    private $footerID;
    private $href;
    private $class;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getFooterID()
    {
        return $this->footerID;
    }

    public function setFooterID($footerID)
    {
        $this->footerID = $footerID;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($href)
    {
        $this->href = $href;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM footer";
        return parent::dohvatiSveSuper($upit);
    }
}