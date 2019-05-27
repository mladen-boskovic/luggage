<?php
$pitanjeObj = new Pitanje(Baza::instanca());
$rezPitanje = $pitanjeObj->dohvatiAktivnaPitanja();

?>
<div class="naslov_svaki">
    <p>Obratite nam se putem formulara</p>
</div>

<div id="contact_sadrzaj">
    <div id="contact_drzac">

        <div>
            <ul>
                <li>Adresa <span class="fa fa-home"></span> Kruševac, Vidovdanska 10</li>
                <li>Telefon <span class="fa fa-phone"></span> 037/581-321</li>
                <li><span class="contactSpan"></span></li>
            </ul>

            <div id="kontakt_anketa">
                <?php if(count($rezPitanje)): ?>
                    <div id="ankete">
                        <h3>Kratka anketa</h3><br/>
                        <p>
                            <select id="selectAnketa">
                                <option value="0">Izaberite pitanje</option>
                                <?php foreach ($rezPitanje as $pitanje): ?>
                                    <option value="<?= $pitanje->pitanjeID ?>"><?= $pitanje->pitanje ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                    </div>
                <?php endif; ?>


                <div id="odgovori">
                </div>

                <div id="glasajDugmeDiv">
                    <p><input type='button' value='Glasaj' name='glasaj' id='glasaj'/></p>
                    <p><input type="button" name="rezultatiDugme" id="rezultatiDugme" value="Rezultati"/></p>
                    <input type="hidden" id="contactKorisnikLogovan" name="contactKorisnikLogovan" value="<?= $korisnikLogovan ?>"/>
                </div>

                <div id="izaberiteOdgovor">
                </div>

            </div>
        </div>



        <div>
            <form id="forma_contact" name="forma_contact">
                <table id="tabela_contact">
                    <tr>
                        <td>Email</td>
                    </tr>
                    <tr>
                        <td><input type="text" id="contactEmail" name="contactEmail"></td>
                    </tr>
                    <tr>
                        <td>
                            <div id="contactEmailGreska" class="ispisGreskeContact"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Poruka</td>
                    </tr>
                    <tr>
                        <td><textarea id="poruka" name="poruka"></textarea><td/>
                    </tr>
                    <tr>
                        <td>
                            <div id="contactPorukaGreska" class="ispisGreskeContact"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="button" id="contactDugme" name="contactDugme" value="POŠALJI"/></td>
                    </tr>
                </table>
            </form>

            <div id="contact_greske">
            </div>

        </div>
    </div>
</div>

<div class="greske">

</div>