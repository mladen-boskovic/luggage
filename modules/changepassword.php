<?php
session_start();

require_once "../classes/SuperKlasa.php";
require_once "../classes/Korisnik.php";
require_once "../classes/Baza.php";


if(!isset($_SESSION['korisnik']))
{
    header("Location: http://localhost/php2sajt1/index.php");
}
else
{
    if(isset($_POST['promenaLozinkeDugme'])){
        header("Content-Type: application/json");
        $code = 404;
        $data = null;

        $korisnikID = $_POST['korisnikID'];
        $trenutnaLozinka = md5($_POST['trenutnaLozinka']);
        $novaLozinka = md5($_POST['novaLozinka']);
        $novaLozinka2 = md5($_POST['novaLozinka2']);

        $promenaLozinkeGreske = [];


        if(!$_POST['trenutnaLozinka']){
            $promenaLozinkeGreske[] = "Polje za trenutnu lozinku mora biti popunjeno";
        } else if(strlen($_POST['trenutnaLozinka']) < 6){
            $promenaLozinkeGreske[] = ("Trenutna lozinka mora imati bar 6 karaktera");
        }

        if(!$_POST['novaLozinka']){
            $promenaLozinkeGreske[] = "Polje za novu lozinku mora biti popunjeno";
        } else if(strlen($_POST['novaLozinka']) < 6){
            $promenaLozinkeGreske[] = ("Nova lozinka mora imati bar 6 karaktera");
        }

        if(!$_POST['novaLozinka2']){
            $promenaLozinkeGreske[] = "Polje za ponovljenu lozinku mora biti popunjeno";
        } else if(strlen($_POST['novaLozinka2']) < 6){
            $promenaLozinkeGreske[] = ("Ponovljena lozinka mora imati bar 6 karaktera");
        }


        if($_POST['novaLozinka'] !== $_POST['novaLozinka2']){
            $promenaLozinkeGreske[] = "Nova lozinka i ponovljena lozinka se ne poklapaju";
        }

        if(count($promenaLozinkeGreske)){
            $code = 422;
            $data = $promenaLozinkeGreske;
        } else{
            $korisnik = new Korisnik(Baza::instanca());
            $korisnik->setKorisnikID($korisnikID);
            $korisnik->setLozinka($trenutnaLozinka);

            $korisnikSelect = $korisnik->promenaLozinkeProvera();


            if($korisnikSelect){
                $korisnik->setKorisnikID($korisnikID);
                $korisnik->setLozinka($novaLozinka);

                $code = $korisnik->promeniLozinku() ? 204 : 500;
            } else{
                $code = 409;
            }
        }
        http_response_code($code);
        echo json_encode(['message' => $data]);
    } else{
        header("Location: http://localhost/php2sajt1/index.php");
    }
}