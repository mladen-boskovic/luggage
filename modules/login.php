<?php
session_start();

require_once "../classes/SuperKlasa.php";
require_once "../classes/Korisnik.php";
require_once "../classes/Baza.php";

if(isset($_POST['loginDugme'])){
    header("Content-Type: application/json");
    $code = 404;
    $data = null;

    $loginKorIme = trim($_POST['loginKorIme']);
    $loginLozinka = md5($_POST['loginLozinka']);
    $reKorIme = "/^[\w\d\.\_]{5,15}$/";
    $loginGreske = [];

    if(!$loginKorIme){
        $loginGreske[] = "Polje za korisničko ime mora biti popunjeno";
    } else if(!preg_match($reKorIme, $loginKorIme)){
        $loginGreske[] = "Korisničko ime mora imati 5-15 karaktera";
    }
    if(!$_POST['loginLozinka']){
        $loginGreske[] = "Polje za lozinku mora biti popunjeno";
    } else if(strlen($_POST['loginLozinka']) < 6){
        $loginGreske[] = ("Lozinka mora imati bar 6 karaktera");
    }

    $korisnicko_ime = addslashes($loginKorIme);
    $lozinka = $loginLozinka;

    if(count($loginGreske)){
        $code = 422;
        $data = $loginGreske;
    } else{
        $korisnik = new Korisnik(Baza::instanca());
        $korisnik->setKorisnickoIme($korisnicko_ime);
        $korisnik->setLozinka($lozinka);

        $korisnikSelect = $korisnik->loginProvera();
        if($korisnikSelect){
            $_SESSION['korisnik'] = $korisnikSelect;
            $data = $korisnikSelect->uloga;
            $code = 200;
        } else{
            $code = 409;
        }
    }
    http_response_code($code);
    echo json_encode(['message' => $data]);
} else{
    header("Location: http://localhost/php2sajt1/index.php");
}