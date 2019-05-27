<?php

class Proizvod extends SuperKlasa
{
    private $proizvodID;
    private $proizvod;
    private $opis;
    private $cena;
    private $pol;
    private $src;
    private $alt;
    private $kategorijaID;
    private $brendID;

    //region Get i Set
    public function getProizvodID()
    {
        return $this->proizvodID;
    }

    public function setProizvodID($proizvodID)
    {
        $this->proizvodID = $proizvodID;
    }

    public function getProizvod()
    {
        return $this->proizvod;
    }

    public function setProizvod($proizvod)
    {
        $this->proizvod = $proizvod;
    }

    public function getOpis()
    {
        return $this->opis;
    }

    public function setOpis($opis)
    {
        $this->opis = $opis;
    }

    public function getCena()
    {
        return $this->cena;
    }

    public function setCena($cena)
    {
        $this->cena = $cena;
    }

    public function getPol()
    {
        return $this->pol;
    }

    public function setPol($pol)
    {
        $this->pol = $pol;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function setSrc($src)
    {
        $this->src = $src;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    public function getKategorijaID()
    {
        return $this->kategorijaID;
    }

    public function setKategorijaID($kategorijaID)
    {
        $this->kategorijaID = $kategorijaID;
    }

    public function getBrendID()
    {
        return $this->brendID;
    }

    public function setBrendID($brendID)
    {
        $this->brendID = $brendID;
    }
    //endregion

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM proizvod p INNER JOIN kategorija k ON p.kategorijaID = k.kategorijaID
                 INNER JOIN brend b ON p.brendID = b.brendID";
        return parent::dohvatiSveSuper($upit);
    }

    public function dohvatiJedan()
    {
        $upit = "SELECT * FROM proizvod p INNER JOIN kategorija k ON p.kategorijaID = k.kategorijaID
                 INNER JOIN brend b ON p.brendID = b.brendID WHERE proizvodID = :proizvodID";
        $podaci = ["proizvodID" => $this->proizvodID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function insertProizvod()
    {
        $upit = "INSERT INTO proizvod (proizvod, opis, cena, pol, src, alt, kategorijaID, brendID)
                 VALUES (:proizvod, :opis, :cena, :pol, :src, :alt, :kategorijaID, :brendID)";
        $podaci =
            [
              "proizvod" => $this->proizvod,
                "opis" => $this->opis,
                "cena" => $this->cena,
                "pol" => $this->pol,
                "src" => $this->src,
                "alt" => $this->alt,
                "kategorijaID" => $this->kategorijaID,
                "brendID" => $this->brendID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function updateProizvodBezSlike()
    {
        $upit = "UPDATE proizvod SET proizvod = :proizvod, opis = :opis, cena = :cena, pol = :pol, alt = :alt, 
                     kategorijaID = :kategorijaID, brendID = :brendID WHERE proizvodID = :proizvodID";
        $podaci =
            [
                "proizvod" => $this->proizvod,
                "opis" => $this->opis,
                "cena" => $this->cena,
                "pol" => $this->pol,
                "alt" => $this->alt,
                "kategorijaID" => $this->kategorijaID,
                "brendID" => $this->brendID,
                "proizvodID" => $this->proizvodID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function updateProizvodSaSlikom()
    {
        $upit = "UPDATE proizvod SET proizvod = :proizvod, opis = :opis, cena = :cena, pol = :pol, src = :src, alt = :alt, 
                     kategorijaID = :kategorijaID, brendID = :brendID WHERE proizvodID = :proizvodID";
        $podaci =
            [
                "proizvod" => $this->proizvod,
                "opis" => $this->opis,
                "cena" => $this->cena,
                "pol" => $this->pol,
                "src" => $this->src,
                "alt" => $this->alt,
                "kategorijaID" => $this->kategorijaID,
                "brendID" => $this->brendID,
                "proizvodID" => $this->proizvodID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function deleteProizvod()
    {
        $upitFkKorpa = "DELETE FROM korpa WHERE proizvodID = :proizvodID";
        $upit = "DELETE FROM proizvod WHERE proizvodID = :proizvodID";
        $podaci = ["proizvodID" => $this->proizvodID];
        $this->baza->izvrsiInsertUpdateDelete($upitFkKorpa, $podaci);
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function dohvatiCetiriNajprodavanijaProizvoda()
    {
        $upit = "SELECT COUNT(k.proizvodID) as kupljen_broj, p.proizvod, p.cena, p.src, p.alt, p.proizvodID FROM korpa k
               INNER JOIN proizvod p ON k.proizvodID = p.proizvodID WHERE k.kupljeno = 1 GROUP BY k.proizvodID ORDER BY kupljen_broj DESC LIMIT 0,4";
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }

    public function filter($upit)
    {
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }
}