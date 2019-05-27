<?php
if(!isset($_GET['reset'])){
    header("Location: http://localhost/php2sajt1/index.php");
} else{
    $token = $_GET['reset'];
    $korisnik = new Korisnik(Baza::instanca());
    $korisnik->setResetPassword($token);

    $korisnikSelect = $korisnik->resetLozinkeTokenProvera();
    if(!$korisnikSelect){
        header('Location: http://localhost/php2sajt1/index.php');
    }
}
?>

<div class="naslov_svaki">
    <p>Resetujte Lozinku</p>
</div>

<div id="reset_lozinke_sadrzaj">
    <div id="reset_lozinke_drzac">
        <form id="formaPromenaLozinke" name="formaPromenaLozinke">
            <table id="tabela_promeni_lozinku">
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
                    <td><input type="button" id="resetLozinkeDugme" name="resetLozinkeDugme" value="PROMENI LOZNKU" class="inputi"/></td>
                </tr>
            </table>
            <input type="hidden" id="promenaLozinkeKorisnikToken" value="<?= $token ?>"/>
        </form>
    </div>

    <div id="resetLozinkeGreske">
    </div>

</div>