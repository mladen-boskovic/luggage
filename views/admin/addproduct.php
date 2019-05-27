<?php
$brendObj = new Brend(Baza::instanca());
$rezultatBrend = $brendObj->dohvatiSve();

$kategorijaObj = new Kategorija(Baza::instanca());
$rezultatKategorija = $kategorijaObj->dohvatiSve();
?>



<div class="naslov_svaki_admin">
    <p>Dodajte Proizvod</p>
</div>

<div id="register_sadrzaj">
    <div id="register_drzac">
        <form id="formaProizvod" name="formaProizvod" enctype="multipart/form-data" method="post" action="modules/admin.php">
            <table>
                <tr>
                    <td colspan="3">
                        <p>Naziv</p>
                        <textarea id="insertProizvodNaziv" name="insertProizvodNaziv" maxlength="50"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>Opis</p>
                        <textarea id="insertProizvodOpis" name="insertProizvodOpis" maxlength="200"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Slika</p>
                        <input type="file" id="insertProizvodSlika" name="insertProizvodSlika"/>
                    </td>
                    <td>
                        <p id="formaProizvodCena_t">Cena</p><br/>
                        <input type="number" id="insertProizvodCena" name="insertProizvodCena"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Brend</p>
                        <select id="insertProizvodBrend" name="insertProizvodBrend">
                            <option value="0">Izaberite</option>
                            <?php foreach ($rezultatBrend as $brend): ?>
                            <option value="<?= $brend->brendID ?>"><?= $brend->brend ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <p id="formaProizvodPol_t">Pol</p><br/>
                        <select id="insertProizvodPol" name="insertProizvodPol">
                            <option value="0">Izaberite</option>
                            <option value="m">Muški</option>
                            <option value="z">Ženski</option>

                        </select>
                    </td>
                    <td>
                        <p id="formaProizvodKategorija_t">Kategorija</p><br/>
                        <select id="insertProizvodKategorija" name="insertProizvodKategorija">
                            <option value="0">Izaberite</option>
                            <?php foreach ($rezultatKategorija as $kategorija): ?>
                                <option value="<?= $kategorija->kategorijaID ?>"><?= $kategorija->kategorija ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><input type="submit" value="DODAJ PROIZVOD" id="addProductDugme" name="addProductDugme"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<div class="admin_greske">

</div>