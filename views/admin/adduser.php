<?php
$ulogaObj = new Uloga(Baza::instanca());
$rezultatUloga = $ulogaObj->dohvatiSve();
?>

<div class="naslov_svaki_admin">
    <p>Dodajte Korisnika</p>
</div>

<div id="register_sadrzaj">
    <div id="register_drzac">
        <form id="forma_register" name="forma_register">
            <table id="tabela_register">
                <tr>
                    <td>Ime</td>
                    <td>Prezime</td>
                </tr>
                <tr>
                    <td><input type="text" id="regIme" name="regIme" placeholder="" autocomplete="on" class="inputi"/></td>
                    <td><input type="text" id="regPrezime" name="regPrezime" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>Korisničko ime</td>
                </tr>
                <tr>
                    <td><input type="text" id="regEmail" name="regEmail" placeholder="" autocomplete="on" class="inputi"/></td>
                    <td><input type="text" id="regKorIme" name="regKorIme" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>

                <tr>
                    <td>Lozinka</td>
                    <td>Ponovite lozinku</td>
                </tr>
                <tr>
                    <td><input type="password" id="regLozinka" name="regLozinka" placeholder="" autocomplete="on" class="inputi"/></td>
                    <td><input type="password" id="regLozinka2" name="regLozinka2" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>
                <tr>
                    <td>Uloga</td>
                    <td id="add_aktivan_t">Aktivan</td>
                </tr>
                <tr>
                    <td>
                        <select id="add_uloga" name="add_uloga">
                            <option value="0">Izaberite</option>
                            <?php foreach($rezultatUloga as $uloga): ?>
                            <option value="<?= $uloga->ulogaID ?>"><?= $uloga->uloga ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select id="add_aktivan" name="add_aktivan">
                            <option value="2">Izaberite</option>
                            <option value="1">Da</option>
                            <option value="0">Ne</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="button" id="addUserDugme" name="addUserDugme" value="DODAJ KORISNIKA" class="inputi"/></td>
                </tr>

            </table>
        </form>
    </div>
</div>

<div class="admin_greske"">

</div>