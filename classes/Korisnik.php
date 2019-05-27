<?php

class Korisnik extends SuperKlasa
{
    private $korisnikID;
    private $ime;
    private $prezime;
    private $email;
    private $korisnicko_ime;
    private $lozinka;
    private $token;
    private $aktivan;
    private $datum_registracije;
    private $ulogaID;
    private $reset_password;

    //region Get i Set
    public function getKorisnikID()
    {
        return $this->korisnikID;
    }

    public function setKorisnikID($korisnikID)
    {
        $this->korisnikID = $korisnikID;
    }

    public function getIme()
    {
        return $this->ime;
    }

    public function setIme($ime)
    {
        $this->ime = $ime;
    }

    public function getPrezime()
    {
        return $this->prezime;
    }

    public function setPrezime($prezime)
    {
        $this->prezime = $prezime;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getKorisnickoIme()
    {
        return $this->korisnicko_ime;
    }

    public function setKorisnickoIme($korisnicko_ime)
    {
        $this->korisnicko_ime = $korisnicko_ime;
    }

    public function getLozinka()
    {
        return $this->lozinka;
    }

    public function setLozinka($lozinka)
    {
        $this->lozinka = $lozinka;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getAktivan()
    {
        return $this->aktivan;
    }

    public function setAktivan($aktivan)
    {
        $this->aktivan = $aktivan;
    }

    public function getDatumRegistracije()
    {
        return $this->datum_registracije;
    }

    public function setDatumRegistracije($datum_registracije)
    {
        $this->datum_registracije = $datum_registracije;
    }

    public function getUlogaID()
    {
        return $this->ulogaID;
    }

    public function setUlogaID($ulogaID)
    {
        $this->ulogaID = $ulogaID;
    }

    public function getResetPassword()
    {
        return $this->reset_password;
    }

    public function setResetPassword($reset_password)
    {
        $this->reset_password = $reset_password;
    }
    //endregion

    public function __construct($baza)
    {
        $this->baza = $baza;
    }

    public function dohvatiSve()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN uloga u ON k.ulogaID = u.ulogaID";
        return parent::dohvatiSveSuper($upit);
    }

    public function dohvatiJednog()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN uloga u ON k.ulogaID = u.ulogaID WHERE k.korisnikID = :korisnikID";
        $podaci = ["korisnikID" => $this->korisnikID];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function registerKorisnik()
    {
        $upit = "INSERT INTO korisnik (ime, prezime, email, korisnicko_ime, lozinka, token, aktivan, datum_registracije, ulogaID, reset_password)
                 VALUES (:ime, :prezime, :email, :korisnicko_ime, :lozinka, :token, :aktivan, :datum_registracije, (SELECT ulogaID FROM uloga WHERE uloga = 'Korisnik'), :reset_password)";
        $podaci =
            [
              "ime" => $this->ime,
                "prezime" => $this->prezime,
                "email" => $this->email,
                "korisnicko_ime" => $this->korisnicko_ime,
                "lozinka" => $this->lozinka,
                "token" => $this->token,
                "aktivan" => $this->aktivan,
                "datum_registracije" => $this->datum_registracije,
                "reset_password" => $this->reset_password
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function activateProvera()
    {
        $upit = "SELECT * FROM korisnik WHERE token = :token";
        $podaci = ["token" => $this->token];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function activate()
    {
        $upit = "UPDATE korisnik SET aktivan = 1 WHERE token = :token";
        $podaci = ["token" => $this->token];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function loginProvera()
    {
        $upit = "SELECT * FROM korisnik k INNER JOIN uloga u ON k.ulogaID=u.ulogaID WHERE korisnicko_ime = :korisnicko_ime AND lozinka = :lozinka AND aktivan = 1";
        $podaci =
            [
                "korisnicko_ime" => $this->korisnicko_ime,
                "lozinka" => $this->lozinka
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci)->fetch();
    }

    public function insertKorisnik()
    {
        $upit = "INSERT INTO korisnik (ime, prezime, email, korisnicko_ime, lozinka, token, aktivan, datum_registracije, ulogaID, reset_password)
                 VALUES (:ime, :prezime, :email, :korisnicko_ime, :lozinka, :token, :aktivan, :datum_registracije, :ulogaID, :reset_password)";
        $podaci =
            [
                "ime" => $this->ime,
                "prezime" => $this->prezime,
                "email" => $this->email,
                "korisnicko_ime" => $this->korisnicko_ime,
                "lozinka" => $this->lozinka,
                "token" => $this->token,
                "aktivan" => $this->aktivan,
                "datum_registracije" => $this->datum_registracije,
                "ulogaID" => $this->ulogaID,
                "reset_password" => $this->reset_password
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function deleteKorisnik()
    {
        $upitFkKorpa = "DELETE FROM korpa WHERE korisnikID = :korisnikID";
        $upitFkAnketa = "DELETE FROM anketa WHERE korisnikID = :korisnikID";
        $upit = "DELETE FROM korisnik WHERE korisnikID = :korisnikID";
        $podaci = ["korisnikID" => $this->korisnikID];
        $this->baza->izvrsiInsertUpdateDelete($upitFkKorpa, $podaci);
        $this->baza->izvrsiInsertUpdateDelete($upitFkAnketa, $podaci);
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function updateKorisnik()
    {
        $upit = "UPDATE korisnik SET ime = :ime, prezime = :prezime, email = :email, korisnicko_ime = :korisnicko_ime, aktivan = :aktivan, ulogaID = :ulogaID
                 WHERE korisnikID = :korisnikID";
        $podaci =
            [
                "ime" => $this->ime,
                "prezime" => $this->prezime,
                "email" => $this->email,
                "korisnicko_ime" => $this->korisnicko_ime,
                "aktivan" => $this->aktivan,
                "ulogaID" => $this->ulogaID,
                "korisnikID" => $this->korisnikID
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function promenaLozinkeProvera()
    {
        $upit = "SELECT * FROM korisnik WHERE korisnikID = :korisnikID AND lozinka = :lozinka";
        $podaci =
            [
                "korisnikID" => $this->korisnikID,
                "lozinka" => $this->lozinka
            ];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function promeniLozinku()
    {
        $upit = "UPDATE korisnik SET lozinka = :lozinka WHERE korisnikID = :korisnikID";
        $podaci =
            [
                "korisnikID" => $this->korisnikID,
                "lozinka" => $this->lozinka
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function resetLozinkeEmailProvera()
    {
        $upit = "SELECT * FROM korisnik WHERE email = :email";
        $podaci = ["email" => $this->email];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function resetLozinkeEmailUspesnaProvera()
    {
        $upit = "UPDATE korisnik SET reset_password = :reset_password WHERE email = :email";
        $podaci = [
            "reset_password" => $this->reset_password,
            "email" => $this->email
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }

    public function resetLozinkeTokenProvera()
    {
        $upit = "SELECT * FROM korisnik WHERE reset_password = :reset_password";
        $podaci =
            [
                "reset_password" => $this->reset_password
            ];
        return $this->baza->izvrsiSelect($upit, $podaci)->fetch();
    }

    public function resetLozinke(){
        $upit = "UPDATE korisnik SET lozinka = :lozinka, reset_password = :reset_password WHERE reset_password = :token";
        $podaci =
            [
                "lozinka" => $this->lozinka,
                "reset_password" => $this->reset_password,
                "token" => $this->token
            ];
        return $this->baza->izvrsiInsertUpdateDelete($upit, $podaci);
    }
}