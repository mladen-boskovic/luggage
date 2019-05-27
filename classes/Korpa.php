<?php

class Korpa extends SuperKlasa
{
    private $korpaID;
    private $korisnikID;
    private $proizvodID;
    private $kupljeno;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getKorpaID()
    {
        return $this->korpaID;
    }

    public function setKorpaID($korpaID)
    {
        $this->korpaID = $korpaID;
    }

    public function getKorisnikID()
    {
        return $this->korisnikID;
    }

    public function setKorisnikID($korisnikID)
    {
        $this->korisnikID = $korisnikID;
    }

    public function getProizvodID()
    {
        return $this->proizvodID;
    }

    public function setProizvodID($proizvodID)
    {
        $this->proizvodID = $proizvodID;
    }

    public function getKupljeno()
    {
        return $this->kupljeno;
    }

    public function setKupljeno($kupljeno)
    {
        $this->kupljeno = $kupljeno;
    }
    //endregion

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM korpa";
        return parent::dohvatiSveSuper($upit);
    }

    public function dodajUKorpu()
    {
        $upit = "INSERT INTO korpa (korisnikID, proizvodID, kupljeno) VALUES (:korisnikID, :proizvodID, 0)";
        $podaci =
            [
                "korisnikID" => $this->korisnikID,
                "proizvodID" => $this->proizvodID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function izbaciIzKorpe()
    {
        $upit = "DELETE FROM korpa WHERE korisnikID = :korisnikID AND proizvodID = :proizvodID AND kupljeno = 0 LIMIT 1";
        $podaci =
            [
                "korisnikID" => $this->korisnikID,
                "proizvodID" => $this->proizvodID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function kupi()
    {
        $upit = "UPDATE korpa SET kupljeno = 1 WHERE korisnikID = :korisnikID";
        $podaci = ["korisnikID" => $this->korisnikID];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function dohvatiNekupljenoKorisnik()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN korpa krp ON k.korisnikID = krp.korisnikID
                 INNER JOIN proizvod p ON krp.proizvodID = p.proizvodID WHERE k.korisnikID = :korisnikID AND kupljeno = 0";
        $podaci = ["korisnikID" => $this->korisnikID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetchAll();
    }

    public function dohvatiNekupljenoAdmin()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN korpa krp ON k.korisnikID = krp.korisnikID
                 INNER JOIN proizvod p ON krp.proizvodID = p.proizvodID WHERE kupljeno = 0";
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }

    public function dohvatiKupljenoKorisnik()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN korpa krp ON k.korisnikID = krp.korisnikID
                 INNER JOIN proizvod p ON krp.proizvodID = p.proizvodID WHERE k.korisnikID = :korisnikID AND kupljeno = 1";
        $podaci = ["korisnikID" => $this->korisnikID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetchAll();
    }

    public function dohvatiKupljenoAdmin()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN korpa krp ON k.korisnikID = krp.korisnikID
                 INNER JOIN proizvod p ON krp.proizvodID = p.proizvodID WHERE kupljeno = 1";
        return $this->baza->izvrsiSelect($upit)->fetchAll();
    }

    public function dohvatiSumuNekupljenihProizvoda()
    {
        $upit = "SELECT SUM(cena) as suma FROM korisnik k INNER JOIN korpa krp ON k.korisnikID = krp.korisnikID
             INNER JOIN proizvod p ON krp.proizvodID = p.proizvodID WHERE k.korisnikID = :korisnikID AND kupljeno = 0";
        $podaci = ["korisnikID" => $this->korisnikID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

}