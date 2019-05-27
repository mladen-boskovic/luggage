<?php
if(!isset($_SESSION['korisnik'])){
    header("Location: http://localhost/php2sajt1/index.php");
}

$id = $_SESSION['korisnik']->korisnikID;
$korisnikObj = new Korisnik(Baza::instanca());
$korisnikObj->setKorisnikID($id);
$korisnik = $korisnikObj->dohvatiJednog();
?>

<div class="naslov_svaki">
    <p>Vaš Profil</p>
</div>

<div id="profile_sadrzaj">
    <div id="profile_drzac">

        <div id="o_korisniku">
            <table>
                <tr>
                    <th colspan="2"> Podaci</th>
                </tr>
                <tr>
                    <td>Ime</td>
                    <td><?= stripcslashes($korisnik->ime) ?></td>
                </tr>
                <tr>
                    <td>Prezime</td>
                    <td><?= stripcslashes($korisnik->prezime) ?></td>
                </tr>
                <tr>
                    <td>Korisničko ime</td>
                    <td><?= stripcslashes($korisnik->korisnicko_ime) ?></td>
                </tr>
                <tr>
                    <td>Uloga</td>
                    <td><?= $korisnik->uloga ?></td>
                </tr>
                <tr>
                    <td>Datum registracije</td>
                    <td><?= date("d.m.Y", $korisnik->datum_registracije) ?></td>
                </tr>
            </table>
        </div>



        <div id="promena_lozinke">
            <form id="formaPromenaLozinke" name="formaPromenaLozinke">
                <table id="tabela_promeni_lozinku">
                    <tr>
                        <td>Trenutna lozinka</td>
                    </tr>
                    <tr>
                        <td><input type="password" id="trenutnaLozinka" name="trenutnaLozinka" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="trenutnaLozinkaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Nova lozinka<td/>
                    </tr>
                    <tr>
                        <td><input type="password" id="novaLozinka" name="novaLozinka" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="novaLozinkaGreska" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Ponovite novu lozinku<td/>
                    </tr>
                    <tr>
                        <td><input type="password" id="novaLozinka2" name="novaLozinka2" placeholder="" class="inputi"/></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="novaLozinkaGreska2" class="ispisGreske"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" id="promenaLozinkeDugme" name="promenaLozinkeDugme" value="PROMENI LOZNKU" class="inputi"/></td>
                    </tr>
                </table>
                <input type="hidden" id="promenaLozinkeKorisnik" value="<?= $korisnik->korisnikID ?>"/>
            </form>

            <div id="promenaLozinkeGreske">
            </div>
        </div>
    </div>
</div>