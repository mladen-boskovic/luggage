<?php
session_start();
require_once "../classes/SuperKlasa.php";
require_once "../classes/Odgovor.php";
require_once "../classes/Anketa.php";
require_once "../classes/Baza.php";



if(isset($_POST['dohvatiOdgovoreDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $pitanjeID = $_POST['pitanjeID'];

    $odgovor = new Odgovor(Baza::instanca());
    $odgovor->setPitanjeID($pitanjeID);

    $odgovori = $odgovor->dohvatiOdgovore();

    $code = $odgovori ? 200 : 409;
    $data = $odgovori;

    http_response_code($code);
    echo json_encode(['message' => $data]);
}


if(isset($_POST['glasajDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $odgovorID = $_POST['odgovorID'];
    $pitanjeID = $_POST['pitanjeID'];
    $korisnikID = $_SESSION['korisnik']->korisnikID;

    $anketa = new Anketa(Baza::instanca());
    $anketa->setOdgovorID($odgovorID);
    $anketa->setPitanjeID($pitanjeID);
    $anketa->setKorisnikID($korisnikID);

    $odgovor = $anketa->glasanjeProvera();
    if($odgovor){
        $code = 422;
    } else{
        $code = $anketa->glasaj() ? 201 : 500;
    }

    http_response_code($code);
    echo json_encode(['message' => $data]);
}


if(isset($_POST['dohvatiRezultateDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $pitanjeID = $_POST['pitanjeID'];

    $anketa = new Anketa(Baza::instanca());
    $anketa->setPitanjeID($pitanjeID);

    $rezultati = $anketa->dohvatiRezultateGlasanja();
    if($rezultati){
        $data = $rezultati;
        $code = 200;
    } else{
        $code = 422;
    }

    http_response_code($code);
    echo json_encode(['message' => $data]);
}


if(empty($_POST['dohvatiOdgovoreDugme']) and empty($_POST['glasajDugme']) and empty($_POST['dohvatiRezultateDugme'])){
    header("Location: http://localhost/php2sajt1/index.php");
}