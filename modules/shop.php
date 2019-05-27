<?php
session_start();
require_once "../classes/SuperKlasa.php";
require_once "../classes/Korpa.php";
require_once "../classes/Baza.php";


if(!isset($_SESSION['korisnik']))
{
    header("Location: http://localhost/php2sajt1/index.php");
}
else
{
    if(isset($_POST['dodajUKorpuDugme'])){
        $code = 404;

        $korisnikID = $_POST['korisnikID'];
        $proizvodID = $_POST['proizvodID'];

        $korpa = new Korpa(Baza::instanca());
        $korpa->setKorisnikID($korisnikID);
        $korpa->setProizvodID($proizvodID);

        $code = $korpa->dodajUKorpu() ? 201 : 500;

        http_response_code($code);
    }


    if(isset($_POST['izbaciIzKorpeDugme'])){
        $code = 404;

        $proizvodID = $_POST['proizvodID'];
        $korisnikID = $_POST['korisnikID'];

        $korpa = new Korpa(Baza::instanca());
        $korpa->setProizvodID($proizvodID);
        $korpa->setKorisnikID($korisnikID);

        $code = $korpa->izbaciIzKorpe() ? 204 : 500;

        http_response_code($code);
    }


    if(isset($_POST['kupiDugme'])){
        $code = 404;

        $korisnikID = $_POST['korisnikID'];

        $korpa = new Korpa(Baza::instanca());
        $korpa->setKorisnikID($korisnikID);

        $code = $korpa->kupi() ? 204 : 500;

        http_response_code($code);
    }


    if(empty($_POST['dodajUKorpuDugme']) and empty($_POST['izbaciIzKorpeDugme']) and empty($_POST['kupiDugme'])){
        header("Location: http://localhost/php2sajt1/index.php");
    }

}
