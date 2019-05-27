<?php

class Anketa extends SuperKlasa
{
    private $anketaID;
    private $korisnikID;
    private $odgovorID;
    private $pitanjeID;

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    //region Get i Set
    public function getAnketaID()
    {
        return $this->anketaID;
    }

    public function setAnketaID($anketaID)
    {
        $this->anketaID = $anketaID;
    }

    public function getKorisnikID()
    {
        return $this->korisnikID;
    }

    public function setKorisnikID($korisnikID)
    {
        $this->korisnikID = $korisnikID;
    }

    public function getOdgovorID()
    {
        return $this->odgovorID;
    }

    public function setOdgovorID($odgovorID)
    {
        $this->odgovorID = $odgovorID;
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
        $upit = "SELECT * FROM anketa";
        return parent::dohvatiSveSuper($upit);
    }

    public function glasanjeProvera()
    {
        $upit = "SELECT * FROM anketa WHERE pitanjeID = :pitanjeID AND korisnikID = :korisnikID";
        $podaci =
            [
                "pitanjeID" => $this->pitanjeID,
                "korisnikID" => $this->korisnikID
            ];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function glasaj()
    {
        $upit = "INSERT INTO anketa (pitanjeID, odgovorID, korisnikID) VALUES (:pitanjeID, :odgovorID, :korisnikID)";
        $podaci =
            [
                "pitanjeID" => $this->pitanjeID,
                "odgovorID" => $this->odgovorID,
                "korisnikID" => $this->korisnikID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function dohvatiRezultateGlasanja()
    {
        $upit = "SELECT COUNT(a.korisnikID) AS broj_glasova, o.odgovor FROM anketa a INNER JOIN odgovor o ON a.odgovorID = o.odgovorID
                 WHERE a.pitanjeID = :pitanjeID GROUP BY o.odgovor";
        $podaci = ["pitanjeID" => $this->pitanjeID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetchAll();
    }
}