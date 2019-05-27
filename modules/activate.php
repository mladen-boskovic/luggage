<?php
require_once "../classes/SuperKlasa.php";
require_once "../classes/Korisnik.php";
require_once "../classes/Baza.php";

if(isset($_GET['activate'])){
    $korisnik = new Korisnik(Baza::instanca());
    $token = $_GET['activate'];
    $korisnik->setToken($token);

    $korisnikSelect = $korisnik->activateProvera();
    if($korisnikSelect){
        if($korisnikSelect->aktivan){
            echo "<h3>Nalog je već aktiviran</h3><h4><a href='http://localhost/php2sajt1/index.php'>Početna stranica</a></h4>";
        } else{
            $korisnikActivate = $korisnik->activate();
            if($korisnikActivate){
                echo "<h3>Uspešna aktivacija naloga!</h3><h4><a href='http://localhost/php2sajt1/index.php?page=login'>Prijavite se</a></h4>";
            } else {
                echo "<h3>Došlo je do greške</h3><h4><a href='http://localhost/php2sajt1/index.php'>Početna stranica</a></h4>";
            }
        }
    } else{
        echo "<h3>Niste registrovani</h3><h4><a href='http://localhost/php2sajt1/index.php&page=register'>Registrujte se</a></h4>";
    }
} else{
    header("Location: http://localhost/php2sajt1/index.php");
}