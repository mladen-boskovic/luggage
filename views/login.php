<div class="naslov_svaki">
    <p>Prijavite se</p>
</div>

<div id="login_sadrzaj">
    <div id="login_drzac">
        <form id="forma_login" name="forma_login">
            <table id="tabela_login">
                <tr>
                    <td>Korisničko ime</td>
                </tr>
                <tr>
                    <td><input type="text" id="loginKorIme" name="loginKorIme" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="loginKorImeGreska" class="ispisGreske"></div>
                    </td>
                </tr>
                <tr>
                    <td>Lozinka<td/>
                </tr>
                <tr>
                    <td><input type="password" id="loginLozinka" name="loginLozinka" placeholder="" autocomplete="on" class="inputi"/></td>
                </tr>
                <tr>
                    <td>
                        <div id="loginLozinkaGreska" class="ispisGreske"></div>
                    </td>
                </tr>
                <tr>
                    <td><input type="button" id="loginDugme" name="loginDugme" value="PRIJAVI SE" class="inputi"/></td>
                </tr>
            </table>
            <br/>
            <a href="index.php?page=register">Niste registrovani?</a><br/>
            <p id="zab_loz_p">Zaboravili ste lozinku?</p>
        </form>
    </div>
</div>

<div class="greske">
</div>

<div id="zab_loz_div">
    <table id="resetPassEmailTabela">
        <tr>
            <td><h3>- Resetovanje lozinke -</h3></td>
        </tr>
        <tr>
            <td>Unesite email</td>
        </tr>
        <tr>
            <td>
                <input type="text" id="resetPassEmail" name="resetPassEmail" placeholder="" autocomplete="on" class="inputi"/>
            </td>
        </tr>
        <tr>
            <td>
                <div id="resetPassEmailGreska" class="ispisGreske"></div>
            </td>
        </tr>
        <tr>
            <td>
                <input type="button" id="resetPassEmailDugme" name="resetPassEmailDugme" value="POTVRDI EMAIL" class="inputi"/>
            </td>
        </tr>

    </table>
</div>

<div id="resetPassEmailIspis">
</div>