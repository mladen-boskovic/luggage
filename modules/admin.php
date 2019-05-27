<?php
session_start();

require_once "../classes/SuperKlasa.php";
require_once "../classes/Korisnik.php";
require_once "../classes/Proizvod.php";
require_once "../classes/Baza.php";


if(!isset($_SESSION['korisnik']))
{
    header("Location: http://localhost/php2sajt1/index.php");
}
else
{
    if($_SESSION['korisnik']->uloga != "Admin")
    {
        header("Location: http://localhost/php2sajt1/index.php");
    }
    else
    {
        /*-----INSERT USER-----*/
        if(isset($_POST['addUserDugme'])){
            header("Content-Type: application/json");
            $code = 404;
            $data = null;

            $regIme = trim($_POST['regIme']);
            $regPrezime = trim($_POST['regPrezime']);
            $regEmail = trim($_POST['regEmail']);
            $regKorIme = trim($_POST['regKorIme']);
            $regLozinka = md5($_POST['regLozinka']);
            $regLozinka2 = md5($_POST['regLozinka2']);
            $add_uloga = $_POST['add_uloga'];
            $add_aktivan = $_POST['add_aktivan'];

            $proveraImePrezime = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/";
            $proveraEmail = "/^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/";
            $proveraKorIme = "/^[\w\d\.\_]{5,15}$/";
            $insPrGreske = [];

            if(!$regIme){
                $insPrGreske[] = "Polje za ime mora biti popunjeno";
            } else if(!preg_match($proveraImePrezime, $regIme)){
                $insPrGreske[] = "Ime nije u dobrom formatu";
            }
            if(!$regPrezime){
                $insPrGreske[] = "Polje za prezime mora biti popunjeno";
            } else if(!preg_match($proveraImePrezime, $regPrezime)){
                $insPrGreske[] = "Prezime nije u dobrom formatu";
            }
            if(!$regEmail){
                $insPrGreske[] = "Polje za email mora biti popunjeno";
            } else if(!preg_match($proveraEmail, $regEmail)){
                $insPrGreske[] = "Email nije u dobrom formatu";
            }
            if(!$regKorIme){
                $insPrGreske[] = "Polje za korisničko ime mora biti popunjeno";
            } else if(!preg_match($proveraKorIme, $regKorIme)){
                $insPrGreske[] = "Korisničko ime mora imati 5-15 karaktera";
            }
            if(!$_POST['regLozinka']){
                $insPrGreske[] = "Polje za lozinku mora biti popunjeno";
            } else if(strlen($_POST['regLozinka']) < 6){
                $insPrGreske[] = ("Lozinka mora imati bar 6 karaktera");
            }
            if(!$_POST['regLozinka2']){
                $insPrGreske[] = "Polje za ponovljenu lozinku mora biti popunjeno";
            } else if(strlen($_POST['regLozinka2']) < 6){
                $insPrGreske[] = "Ponovljena lozinka mora imati bar 6 karaktera";
            }
            if($_POST['regLozinka'] !== $_POST['regLozinka2']){
                $insPrGreske[] = "Lozinka i ponovljena lozinka se ne poklapaju";
            }
            if($add_uloga == "0"){
                $insPrGreske[] = "Morate odabrati ulogu";
            }
            if($add_aktivan == "2"){
                $insPrGreske[] = "Morate odabrati aktivnost naloga";
            }

            $ime = addslashes($regIme);
            $prezime = addslashes($regPrezime);
            $email = addslashes($regEmail);
            $korisnicko_ime = addslashes($regKorIme);
            $lozinka = $regLozinka;
            $aktivan = $add_aktivan;
            $ulogaID = $add_uloga;

            if(count($insPrGreske)){
                $code = 422;
                $data = $insPrGreske;
            } else {
                $token = md5(sha1($email . $korisnicko_ime . time()));
                $reset_password = md5(sha1($ime . $email . time() . rand()));
                $datum_registracije = time();

                $korisnik = new Korisnik(Baza::instanca());
                $korisnik->setIme($ime);
                $korisnik->setPrezime($prezime);
                $korisnik->setEmail($email);
                $korisnik->setKorisnickoIme($korisnicko_ime);
                $korisnik->setLozinka($lozinka);
                $korisnik->setToken($token);
                $korisnik->setAktivan($aktivan);
                $korisnik->setDatumRegistracije($datum_registracije);
                $korisnik->setUlogaID($ulogaID);
                $korisnik->setResetPassword($reset_password);

                $code = $korisnik->insertKorisnik() ? 201 : 409;
            }
            http_response_code($code);
            echo json_encode(['message' => $data]);
        }



        /*-----DELETE USER-----*/
        if(isset($_POST['deleteUserDugme'])){
            $code = 404;
            $data = null;

            $korisnikID = $_POST['korisnikID'];

            $korisnik = new Korisnik(Baza::instanca());
            $korisnik->setKorisnikID($korisnikID);

            $code = $korisnik->deleteKorisnik() ? 204 : 500;

            http_response_code($code);
        }



        /*-----UPDATE USER-----*/
        if(isset($_POST['updateUserDugme'])){
            $code = 404;
            $data = null;

            $regIme = trim($_POST['regIme']);
            $regPrezime = trim($_POST['regPrezime']);
            $regEmail = trim($_POST['regEmail']);
            $regKorIme = trim($_POST['regKorIme']);
            $add_uloga = $_POST['add_uloga'];
            $add_aktivan = $_POST['add_aktivan'];
            $idUpdate = $_POST['idUpdate'];

            $proveraImePrezime = "/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,12}){0,1}$/";
            $proveraEmail = "/^[\w]+[\.\w\d]*[\w\d]+\@[\w]+([\.][\w]+)+$/";
            $proveraKorIme = "/^[\w\d\.\_]{5,15}$/";
            $insPrGreske = [];

            if(!$regIme){
                $insPrGreske[] = "Polje za ime mora biti popunjeno";
            } else if(!preg_match($proveraImePrezime, $regIme)){
                $insPrGreske[] = "Ime nije u dobrom formatu";
            }
            if(!$regPrezime){
                $insPrGreske[] = "Polje za prezime mora biti popunjeno";
            } else if(!preg_match($proveraImePrezime, $regPrezime)){
                $insPrGreske[] = "Prezime nije u dobrom formatu";
            }
            if(!$regEmail){
                $insPrGreske[] = "Polje za email mora biti popunjeno";
            } else if(!preg_match($proveraEmail, $regEmail)){
                $insPrGreske[] = "Email nije u dobrom formatu";
            }
            if(!$regKorIme){
                $insPrGreske[] = "Polje za korisničko ime mora biti popunjeno";
            } else if(!preg_match($proveraKorIme, $regKorIme)){
                $insPrGreske[] = "Korisničko ime mora imati 5-15 karaktera";
            }
            if($add_uloga == "0"){
                $insPrGreske[] = "Morate odabrati ulogu";
            }
            if($add_aktivan == "2"){
                $insPrGreske[] = "Morate odabrati aktivnost naloga";
            }

            $ime = addslashes($regIme);
            $prezime = addslashes($regPrezime);
            $email = addslashes($regEmail);
            $korisnicko_ime = addslashes($regKorIme);
            $aktivan = $add_aktivan;
            $ulogaID = $add_uloga;
            $korisnikID = $idUpdate;

            if(count($insPrGreske)){
                $code = 422;
                $data = $insPrGreske;
            } else {
                $korisnik = new Korisnik(Baza::instanca());
                $korisnik->setIme($ime);
                $korisnik->setPrezime($prezime);
                $korisnik->setEmail($email);
                $korisnik->setKorisnickoIme($korisnicko_ime);
                $korisnik->setAktivan($aktivan);
                $korisnik->setUlogaID($ulogaID);
                $korisnik->setKorisnikID($korisnikID);

                $code = $korisnik->updateKorisnik() ? 204 : 409;
            }
            http_response_code($code);
            echo json_encode(['message' => $data]);
        }



        /*-----INSERT PRODUCT-----*/
        if(isset($_POST['addProductDugme'])){

            $insertProizvodNaziv = trim($_POST['insertProizvodNaziv']);
            $insertProizvodOpis = trim($_POST['insertProizvodOpis']);
            $insertProizvodSlika = $_FILES['insertProizvodSlika'];
            $insertProizvodCena = $_POST['insertProizvodCena'];
            $insertProizvodBrend = $_POST['insertProizvodBrend'];
            $insertProizvodPol = $_POST['insertProizvodPol'];
            $insertProizvodKategorija = $_POST['insertProizvodKategorija'];

            $insPrGreske = [];

            if(!$insertProizvodNaziv){
                $insPrGreske[] = "Polje za naziv mora biti popunjeno";
            } else if(strlen($insertProizvodNaziv) > 50){
                $insPrGreske[] = "Naziv ne sme biti duži od 50 karaktera";
            }
            if(!$insertProizvodOpis){
                $insPrGreske[] = "Polje za opis mora biti popunjeno";
            } else if(strlen($insertProizvodOpis) > 200){
                $insPrGreske[] = "Opis ne sme biti duži od 200 karaktera";
            }
            if(!$insertProizvodCena){
                $insPrGreske[] = "Polje za cenu mora biti popunjeno";
            }
            if($insertProizvodBrend == "0"){
                $insPrGreske[] = "Morate odabrati brend";
            }
            if($insertProizvodPol == "0"){
                $insPrGreske[] = "Morate odabrati pol";
            }
            if($insertProizvodKategorija == "0"){
                $insPrGreske[] = "Morate odabrati kategoriju";
            }
            if(!$insertProizvodSlika){
                $insPrGreske[] = "Morate odabrati sliku";
            }

            $uploadFolder = "../images/upload/";
            $tmpName = $insertProizvodSlika['tmp_name'];
            $velicinaSlike = $insertProizvodSlika['size'];
            $maxVelicina = 2048000;
            $nazivSlike = time() . $insertProizvodSlika['name'];
            $tip = $insertProizvodSlika['type'];
            $putanja = $uploadFolder . $nazivSlike;

            if($velicinaSlike > $maxVelicina){
                $insPrGreske[] = "Slika ne sme biti veća od 2MB";
            }

            $reSlika = "/image\/jpg|image\/jpeg|image\/png/i";

            if(!preg_match($reSlika, $tip)){
                $insPrGreske[] = "Slika mora biti jpg, jpeg ili png formata";
            }

            $naziv = addslashes($insertProizvodNaziv);
            $opis = addslashes($insertProizvodOpis);
            $cena = $insertProizvodCena;
            $pol = $insertProizvodPol;
            $src = addslashes($nazivSlike);
            $alt = addslashes($insertProizvodNaziv);
            $kategorijaID = $insertProizvodKategorija;
            $brendID = $insertProizvodBrend;

            $prebacivanjeSlike = move_uploaded_file($tmpName, $putanja);

            if(!$prebacivanjeSlike){
                $insPrGreske[] = "Greška pri dodavanju slike";
            }

            if(count($insPrGreske)){
                foreach ($insPrGreske as $greska){
                    echo "<h3>$greska</h3>";
                }

            } else {
                $proizvod = new Proizvod(Baza::instanca());
                $proizvod->setProizvod($naziv);
                $proizvod->setOpis($opis);
                $proizvod->setCena($cena);
                $proizvod->setPol($pol);
                $proizvod->setSrc($src);
                $proizvod->setAlt($alt);
                $proizvod->setKategorijaID($kategorijaID);
                $proizvod->setBrendID($brendID);

                $insertKorisnik = $proizvod->insertProizvod();
                if($insertKorisnik)
                {
					header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                    echo "<h3>Uspešno ste dodali proizvod!</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodima</h4>";
                }
                else
                {
					header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                    echo "<h3>Greška pri dodavanju proizvoda, pokušajte kasnije.</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodima</h4>";
                }
            }
        }



        /*-----DELETE PRODUCT-----*/
        if(isset($_POST['deleteProductDugme'])){
            $code = 404;
            $data = null;

            $proizvodID = $_POST['proizvodID'];

            $proizvod = new Proizvod(Baza::instanca());
            $proizvod->setProizvodID($proizvodID);

            $code = $proizvod->deleteProizvod() ? 204 : 500;

            http_response_code($code);
        }



        /*-----UPDATE PRODUCT-----*/
        if(isset($_POST['updateProductDugme'])){

            $updateProizvodNaziv = trim($_POST['updateProizvodNaziv']);
            $updateProizvodOpis = trim($_POST['updateProizvodOpis']);
            $updateProizvodSlika = $_FILES['insertProizvodSlika'];
            $updateProizvodCena = $_POST['insertProizvodCena'];
            $updateProizvodBrend = $_POST['insertProizvodBrend'];
            $updateProizvodPol = $_POST['insertProizvodPol'];
            $updateProizvodKategorija = $_POST['insertProizvodKategorija'];
            $updatePrID = $_POST['updatePrID'];

            $updPrGreske = [];

            if(!$updateProizvodNaziv){
                $updPrGreske[] = "Polje za naziv mora biti popunjeno";
            } else if(strlen($updateProizvodNaziv) > 50){
                $updPrGreske[] = "Naziv ne sme biti duži od 50 karaktera";
            }
            if(!$updateProizvodOpis){
                $updPrGreske[] = "Polje za opis mora biti popunjeno";
            } else if(strlen($updateProizvodOpis) > 200){
                $updPrGreske[] = "Opis ne sme biti duži od 200 karaktera";
            }
            if(!$updateProizvodCena){
                $updPrGreske[] = "Polje za cenu mora biti popunjeno";
            }
            if($updateProizvodBrend == "0"){
                $updPrGreske[] = "Morate odabrati brend";
            }
            if($updateProizvodPol == "0"){
                $updPrGreske[] = "Morate odabrati pol";
            }
            if($updateProizvodKategorija == "0"){
                $updPrGreske[] = "Morate odabrati kategoriju";
            }


            //AKO NIJE UPLOAD-ovao SLIKU
            if($updateProizvodSlika['name'] == ""){
                $naziv = addslashes($updateProizvodNaziv);
                $opis = addslashes($updateProizvodOpis);
                $cena = $updateProizvodCena;
                $pol = $updateProizvodPol;
                $alt = addslashes($updateProizvodNaziv);
                $kategorijaID = $updateProizvodKategorija;
                $brendID = $updateProizvodBrend;
                $proizvodID = $updatePrID;

                if(count($updPrGreske)){
                    foreach ($updPrGreske as $greska){
                        echo "<h3>$greska</h3>";
                    }

                } else {
                    $proizvod = new Proizvod(Baza::instanca());
                    $proizvod->setProizvod($naziv);
                    $proizvod->setOpis($opis);
                    $proizvod->setCena($cena);
                    $proizvod->setPol($pol);
                    $proizvod->setAlt($alt);
                    $proizvod->setKategorijaID($kategorijaID);
                    $proizvod->setBrendID($brendID);
                    $proizvod->setProizvodID($proizvodID);

                    $updateBezSlikeKorisnik = $proizvod->updateProizvodBezSlike();
                    if($updateBezSlikeKorisnik)
                    {
						header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                        echo "<h3>Uspešno ste izmenili proizvod!</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodima</h4>";
                    }
                    else
                    {
						header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                        echo "<h3>Greška pri izmeni proizvoda.</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodima</h4>";
                    }
                }

                // AKO JESTE UPLOAD-ovao SLIKU
            } else {
                $uploadFolder = "../images/upload/";
                $tmpName = $updateProizvodSlika['tmp_name'];
                $velicinaSlike = $updateProizvodSlika['size'];
                $maxVelicina = 2048000;
                $nazivSlike = time() . $updateProizvodSlika['name'];
                $tip = $updateProizvodSlika['type'];
                $putanja = $uploadFolder . $nazivSlike;

                if($velicinaSlike > $maxVelicina){
                    $updPrGreske[] = "Slika ne sme biti veća od 2MB";
                }

                $reSlika = "/image\/jpg|image\/jpeg|image\/png/i";

                if(!preg_match($reSlika, $tip)){
                    $updPrGreske[] = "Slika mora biti jpg, jpeg ili png formata";
                }

                $naziv = addslashes($updateProizvodNaziv);
                $opis = addslashes($updateProizvodOpis);
                $cena = $updateProizvodCena;
                $pol = $updateProizvodPol;
                $src = addslashes($nazivSlike);
                $alt = addslashes($updateProizvodNaziv);
                $kategorijaID = $updateProizvodKategorija;
                $brendID = $updateProizvodBrend;
                $proizvodID = $updatePrID;

                $prebacivanjeSlike = move_uploaded_file($tmpName, $putanja);

                if(!$prebacivanjeSlike){
                    $updPrGreske[] = "Greška pri dodavanju slike";
                }

                if(count($updPrGreske)){
                    foreach ($updPrGreske as $greska){
                        echo "<h3>$greska</h3>";
                    }
                } else {
                    $proizvod = new Proizvod(Baza::instanca());
                    $proizvod->setProizvod($naziv);
                    $proizvod->setOpis($opis);
                    $proizvod->setCena($cena);
                    $proizvod->setPol($pol);
                    $proizvod->setSrc($src);
                    $proizvod->setAlt($alt);
                    $proizvod->setKategorijaID($kategorijaID);
                    $proizvod->setBrendID($brendID);
                    $proizvod->setProizvodID($proizvodID);

                    $updateSaSlikomKorisnik = $proizvod->updateProizvodSaSlikom();
                    if ($updateSaSlikomKorisnik) {
						header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                        echo "<h3>Uspešno ste izmenili proizvod!</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodima</h4>";
                    } else {
						header('Refresh: 5; URL=http://localhost/php2sajt1/index.php?page=admin&adminaction=allproducts');
                        echo "<h3>Greška pri izmeni proizvoda.</h3><h4>Uskoro ćete biti prebačeni na admin stranicu sa svim proizvodi</h4>";
                    }
                }
            }
        }


        if(empty($_POST['addUserDugme']) and empty($_POST['deleteUserDugme']) and empty($_POST['updateUserDugme']) and empty($_POST['addProductDugme']) and empty($_POST['deleteProductDugme']) and empty($_POST['updateProductDugme'])){
            header("Location: http://localhost/php2sajt1/index.php");
        }

    }
}